"""Upload a local directory recursively to a remote path via SFTP."""
import os, sys, paramiko, stat

def upload_dir(sftp, local_path, remote_path):
    """Recursively upload local_path to remote_path."""
    try:
        sftp.mkdir(remote_path)
    except IOError:
        pass

    for item in os.listdir(local_path):
        local_item = os.path.join(local_path, item)
        remote_item = remote_path.rstrip("/") + "/" + item
        if os.path.isdir(local_item):
            upload_dir(sftp, local_item, remote_item)
        else:
            sftp.put(local_item, remote_item)
            print(f"  -> {remote_item}")

def main():
    if len(sys.argv) < 3:
        print("Usage: upload_dir.py <local_dir> <remote_dir>")
        sys.exit(2)
    local = sys.argv[1]
    remote = sys.argv[2]

    host = "46.202.174.126"; port = 65002; user = "u352429374"
    password = os.environ["OGS_SSH_PASSWORD"]

    print(f"Connecting to {user}@{host}:{port}...")
    t = paramiko.Transport((host, port))
    t.connect(username=user, password=password)
    sftp = paramiko.SFTPClient.from_transport(t)

    print(f"Uploading {local} -> {remote}")
    upload_dir(sftp, local, remote)
    print("Done.")
    sftp.close(); t.close()

if __name__ == "__main__":
    main()
