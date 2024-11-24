## **HLS Video Streaming App Documentation**

### **Overview:**

This application provides authenticated access to HLS (HTTP Live Streaming) content. It uses PHP for authentication, serves `.ts` video segments securely, and utilizes `hls.js` for dynamic video streaming. The user must authenticate before viewing the videos, and the system supports re-authentication during video playback.

---

### **File Structure:**

```
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
```

---

### **1. Setup Instructions:**

1. **Clone or Download the Repository**:
   - Clone or download the repository to your local machine or web server's root directory (`htdocs` for XAMPP, `www` for Apache, etc.).

2. **Install PHP**:
   - Ensure PHP (7.4 or higher, preferably PHP 8.x) is installed and configured on your server.

3. **Configure Web Server**:
   - Configure Apache or Nginx to serve the `public/` directory as the web root.

4. **Permissions**:
   - Ensure the `videos/` directory has **read** permissions so that the video files can be served properly.

---

### **2. Authentication Workflow:**

- **Login**:
  - Users log in using `login.php`. Upon successful authentication, they are redirected to the video player page (`player.php`).
  - Invalid login attempts show an error message.

- **Session Management**:
  - Sessions are stored in PHP's default session mechanism. Once authenticated, the user can access the secure video pages.

---

### **3. Video Streaming**:

- **HLS Segmentation**:
  - The `.m3u8` playlist file links to the `.ts` video segments. These segments are served dynamically by `secure.php` upon successful authentication.
  - The segments are dynamically loaded one at a time using `hls.js`.

- **Using `hls.js`**:
  - `hls.js` is used to load and stream the `.m3u8` file and its associated `.ts` segments. It fetches segments on demand, reducing unnecessary pre-loading.

---

### **4. Reauthentication**:

- **Re-authentication Workflow**:
  - After the first video segment finishes, the `reauthenticate.php` script checks if the session is still valid.
  - If the session is valid, the video continues. Otherwise, the user is redirected to `login.php`.

- **AJAX Re-authentication**:
  - An AJAX request is sent to the `reauthenticate.php` endpoint to verify if the session is still active. If the session is invalid, the user is logged out and redirected to the login page.

---

### **5. Production Considerations**:

- **Optimize Video Segments**:
  - Use tools like **FFmpeg** to properly segment videos into `.ts` files, ensuring they are optimized for streaming (with small, manageable segment sizes).

- **FFmpeg** can be used to segment large video files into smaller `.ts` chunks. Segmenting videos properly is crucial for smooth playback in HLS.
- Example command to segment a video file using FFmpeg:
  ```bash
  ffmpeg -i input.mp4 -acodec aac -vcodec libx264 -f segment -segment_time 10 -segment_list output.m3u8 output%03d.ts
  ```

- **Cache Video Segments**:
  - Implement caching for `.ts` files on both the client and server sides to reduce load times and server strain.


- **Security**:
  - Always use **HTTPS** to ensure secure communication, especially for sensitive data (login credentials and video access).
  - Protect the `secure.php` script to ensure that only authenticated users can access the video files.

- **Session Timeout**:
  - The session expiration timeout can be adjusted in the PHP configuration (`session.gc_maxlifetime`).
  - Periodic checks with `reauthenticate.php` ensure the user session remains active during video playback.

- **Cross-Browser Compatibility**:
  - Test video playback in different browsers (Chrome, Firefox, Safari) to ensure compatibility with HLS playback. `hls.js` helps with this by providing HLS support in non-Safari browsers.
  - Ensure that `secure.php` handles file access control and session checks to prevent unauthorized access to the video files.

---

### **Credits:**

- **Project Developed by**:
  - **Shubham Vishwakarma**
  - GitHub Profile: [https://github.com/itsbhm](https://github.com/itsbhm)

---

### **Final Notes**:

This documentation covers the key components and setup for your HLS video streaming application, with secure authentication and session handling. It provides a production-ready solution with video segmentation and reauthentication features.