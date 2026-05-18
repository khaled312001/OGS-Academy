"""
SSH runner for OGS Academy deployment on Hostinger.
Connects via paramiko and runs commands one at a time, printing live output.

Usage:
    python ssh_runner.py "cd ~ && pwd && ls -la"
    python ssh_runner.py --file commands.sh
"""
import sys
import os
import argparse
import paramiko
from getpass import getpass

HOST = os.environ.get("OGS_SSH_HOST", "46.202.174.126")
PORT = int(os.environ.get("OGS_SSH_PORT", "65002"))
USER = os.environ.get("OGS_SSH_USER", "u352429374")
PASSWORD = os.environ.get("OGS_SSH_PASSWORD", "")


def connect():
    client = paramiko.SSHClient()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    client.connect(
        hostname=HOST,
        port=PORT,
        username=USER,
        password=PASSWORD,
        timeout=20,
        banner_timeout=20,
        auth_timeout=20,
        allow_agent=False,
        look_for_keys=False,
    )
    return client


def run(client, cmd, get_pty=False, timeout=300):
    """Run a single command and stream output."""
    print(f"\n$ {cmd}")
    print("-" * 80)
    stdin, stdout, stderr = client.exec_command(cmd, get_pty=get_pty, timeout=timeout)
    stdout.channel.set_combine_stderr(True)
    for line in iter(stdout.readline, ""):
        if not line:
            break
        sys.stdout.write(line)
        sys.stdout.flush()
    exit_code = stdout.channel.recv_exit_status()
    print(f"--- exit: {exit_code}")
    return exit_code


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("cmd", nargs="?", help="Single command to run")
    parser.add_argument("--file", help="Path to file with commands (one per line)")
    parser.add_argument("--pty", action="store_true", help="Request a pty (for interactive cmds)")
    args = parser.parse_args()

    if not PASSWORD:
        print("ERROR: OGS_SSH_PASSWORD env var not set", file=sys.stderr)
        sys.exit(2)

    client = None
    try:
        print(f"Connecting to {USER}@{HOST}:{PORT}...")
        client = connect()
        print("Connected.\n")

        if args.file:
            with open(args.file, "r", encoding="utf-8") as f:
                for raw in f:
                    line = raw.strip()
                    if not line or line.startswith("#"):
                        continue
                    code = run(client, line, get_pty=args.pty)
                    if code != 0:
                        print(f"\n!! Command failed with exit {code} — aborting.")
                        sys.exit(code)
        elif args.cmd:
            sys.exit(run(client, args.cmd, get_pty=args.pty))
        else:
            print("Provide either a cmd or --file <path>")
            sys.exit(2)
    finally:
        if client:
            client.close()


if __name__ == "__main__":
    main()
