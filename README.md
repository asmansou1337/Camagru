# Camagru Project

- This web project is a web application allowing to make basic photo and video editing using a webcam and some predefined images.
- Made with PHP/Mysql and Vanilla JS.
- This project is part of the 1337 Khouribga Curriculum.

![Alt text](screenshots/home.png?raw=true "Home")

**User features**
- The application should allow a user to sign up by asking at least a valid email address, an username and a password with at least a minimum level of complexity.
- At the end of the registration process, the user should confirm his account via a unique link sent at the email address fullfiled in the registration form.

![Alt text](screenshots/signup.png?raw=true "Sign Up")

- The user should then be able to connect using his username and his password. He also should be able to tell the application to send a password reinitialisation mail, if he forget his password.

![Alt text](screenshots/login.png?raw=true "Login")

- The user should be able to disconnect in one click at any time on any page.

![Alt text](screenshots/home-connected.png?raw=true "Home")

- Once connected, an user should modify his username, mail address or password.

![Alt text](screenshots/edit-profile.png?raw=true "Edit")
![Alt text](screenshots/edit-profile1.png?raw=true "Edit")

**Gallery features**
- This part is public and must display all the images edited by all the users, ordered by date of creation. 

![Alt text](screenshots/gallery-non-connected.png?raw=true "Gallery")
![Alt text](screenshots/post-detail-non-connected.png?raw=true "Gallery")

- It should also allow (only) a connected user to like them and/or comment them.

![Alt text](screenshots/gallery.png?raw=true "Gallery")

- When an image receives a new comment, the author of the image should be notified by email. This preference must be set as true by default but can be deactivated in
user’s preferences.

![Alt text](screenshots/post-detail.png?raw=true "Gallery")

- The list of images must be paginated, with at least 5 elements per page.

**Editing features**
- This page should contain 2 sections:
  - A main section containing the preview of the user’s webcam, the list of superposable images and a button allowing to capture a picture.
  - A side section displaying thumbnails of all previous pictures taken.

![Alt text](screenshots/upload.png?raw=true "Upload")
![Alt text](screenshots/upload2.png?raw=true "Upload")
![Alt text](screenshots/upload3.png?raw=true "Upload")

**Authorized languages:**
◦ [Server] PHP
◦ [Client] HTML - CSS - JavaScript
