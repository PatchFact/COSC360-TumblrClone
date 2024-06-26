# Tumblr Clone - COSC 360 Project

Esteban Martínez, Katie Van Rooyen, Jaidyn Gordon-Mason.

# Setup

-   Copy the files to `htdocs` in your XAMPP folder (you can place them in their own folder inside `htdocs` for organization)
-   Create a file called `dbDetails.php` with the following structure to connect to your local database

```
<?php
    define("DBHOST", "localhost");
    define("DBNAME", "your database name");
    define("DBUSER", "your user");
    define("DBPASS", "your password");
```

-   Use the provided `AraDatabase.sql` to create the database in MySQL
    -   You can use `testData.sql` to populate the database with example data
-   Start the database with XAMPP as well as the PHP server
-   Go to `127.0.0.1/index.php` to start

# Milestone 1 - Proposal

Project proposal can be found [here](./docs/Proposal.pdf).

# Milestone 2 - Client-side Experience

## Esteban

-   [x] Layout document (Planned layout of your page in hardcopy/electronic copy showing elements, sizes, placement – this is the plan for what your site will look like)
-   [x] Discussion regarding the design and styles of all pages
-   [x] Log-In HTML Layout

## Jaidyn

-   [x] Organization of pages (How are pages linked? – site map)
-   [x] Homepage HTML Layout
-   [x] Profile Page HTML Layout

## Katie

-   [x] Logic process (How will a user engage with site?): This needs to include all processes for how the user/admin will engage site.
-   [x] New Post HTML Layout

# Minimal Core Functionality

This is the overall checklist needed for the project

## Minimum Objectives

### Esteban

-   [x] Database Design
-   [x] User stays logged in (state)
-   [x] Login/Register
    -   [x] Login
        -   [x] Set default pfp
    -   [x] Logout
    -   [x] Register with
        -   [x] Email
        -   [x] Username
        -   [x] Password
    -   [x] Admin Registration
    -   [x] Form validation
    -   [x] Security
    -   [x] Cannot register existing user
    -   [x] Form validation
    -   [x] Security
    -   [x] Banned users can't log in
-   [x] Profile Page
    -   [x] Display pfp
    -   [x] If same profile as logged in user
        -   [x] Edit Profile
            -   [x] Email
            -   [x] Password
            -   [x] Username
            -   [x] Profile Picture
                -   [x] Stored in Database
            -   [x] Form validation
                -   [x] Security (sanitizing input)
-   [x] My Posts
-   [x] Follow system
    -   [x] Followers
    -   [x] Following
-   [x] Profile sidebar component
-   [ ] Forgot password?
-   [x] Routing errors/authorization

### Katie

-   [x] Posts
    -   [x] userPost.php
        -   [x] Comments
            -   [x] Asynchronous viewing (AJAX)
        -   [x] Be able to edit if you are owner
    -   [x] Register users can
        -   [x] Make posts
            -   [x] Form validation
            -   [x] Security (sanitizing input)
        -   [x] Make comments

### Jaidyn

-   [x] Admin Page
    -   [x] Search for user by name, email, post
    -   [x] Enable/disable user
    -   [x] Edit/remove Posts
-   [x] Server-side
    -   [x] Deployment to cosc360.ok.ubc.ca (?)
    -   [x] Error handling (404)
-   [ ] Posts Feed
    -   [x] Home Page
        -   [x] Browse posts (registered or unregistered)
    -   [ ] Search for items/posts by keyword (registered or unregistered)

## Additional Functionality

-   Search and analysis for topics/items
-   Hot threads/hot item tracking
-   Visual display of updates, etc (site usage charts, etc)
-   Activity by date
-   Tracking (including utilizing tracking API or your own with visualization tools)
-   Collapsible items/treads without page reloading
-   Alerts on page changes
-   Admin view reports on usage (with filtering)
-   Styling flourishes
-   Responsive layout for mobile
-   Tracking comment history from a user’s perspective
-   Accessibility
-   Your choice (this is your opportunity to add additional flourish to your site but will need to be documented in the final report)
