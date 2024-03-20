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
-   [ ] Login/Register
    -   [ ] Login
    -   [ ] User stays logged in (state)
    -   [ ] Register with
        -   [ ] Email
        -   [ ] Username
        -   [ ] Password
    -   [ ] Form validation
    -   [ ] Security
    -   [ ] Banned users can't log in
-   [ ] Profile Page
    -   [ ] Edit Profile
        -   [ ] Email
        -   [ ] Password
        -   [ ] Username
        -   [ ] Profile Picture
            -   [ ] Stored in Database
        -   [ ] Form validation
            -   [ ] Security (sanitizing input)

### Katie

-   [ ] Posts
    -   [ ] Home Page
    -   [ ] Browse posts (registered or unregistered)
        -   [ ] Asynchronous viewing (AJAX)
    -   [ ] Register users can
        -   [ ] Make posts
            -   [ ] Form validation
            -   [ ] Security (sanitizing input)
        -   [ ] Make comments
    -   [ ] Search for items/posts by keyword (registered or unregistered)
    -   [ ] Database storage
        -   [ ] Discussion threads (Posts)

### Jaidyn

-   [ ] Admin Page
    -   [ ] Search for user by name, email, post
    -   [ ] Enable/disable user
    -   [ ] Edit/remove Posts
-   [ ] Server-side
    -   [ ] Deployment to cosc360.ok.ubc.ca (?)
    -   [ ] Error handling (404)
    -   [ ] Breadcrumbs

### All

-   [ ] Preliminary summary document

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
