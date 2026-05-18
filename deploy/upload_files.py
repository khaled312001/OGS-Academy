"""Upload specific files to server via SFTP.
Usage:
    python upload_files.py <pair>...

Each pair is "local|remote" (pipe-separated).
"""
import os, sys, paramiko

def main():
    if len(sys.argv) < 2:
        print("Usage: upload_files.py 'local|remote' [...]"); sys.exit(2)
    host = "46.202.174.126"; port = 65002; user = "u352429374"
    password = os.environ["OGS_SSH_PASSWORD"]
    t = paramiko.Transport((host, port))
    t.connect(username=user, password=password)
    sftp = paramiko.SFTPClient.from_transport(t)
    for arg in sys.argv[1:]:
        local, remote = arg.split("|")
        sftp.put(local, remote)
        print(f"  -> {remote}")
    sftp.close(); t.close()

if __name__ == "__main__":
    main()
