├── appStructure.md                  # Documentation of the app structure
├── assets                           # Folder for static assets (CSS, JS, images, etc.)
├── includes                         # Includes for reusable functions (e.g., config, auth)
│   ├── auth.php                     # Authentication logic (for login, session validation)
│   └── config.php                   # Configuration file (e.g., database, environment settings)
├── public                           # Public-facing files (accessible via the web)
│   ├── index.php                    # Landing page or default page of your app
│   ├── login.php                    # Login page (for user authentication)
│   ├── logout.php                   # Logout logic (ends user session)
│   ├── player.php                   # HLS video player page (where the video is displayed)
│   ├── secure.php                   # PHP script to serve video files (secure access)
│   └── reauthenticate.php           # Reauthentication script (checks user session)
└── videos                           # Folder for storing video segments and HLS files
    ├── Readme.md                    # Instructions on the `videos` directory
    ├── ffmpeg                        # Folder for any ffmpeg related scripts or binaries
    ├── output.m3u8                  # The HLS playlist file (the video index)
    ├── output0.ts                   # First video segment
    ├── output1.ts                   # Second video segment
    ├── output2.ts                   # Third video segment
    ├── output3.ts                   # Fourth video segment
    └── raw                           # Folder for raw video source files
        └── input.mp4                 # Original raw input video file
