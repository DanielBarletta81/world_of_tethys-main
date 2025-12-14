# World of Tethys Theme

This folder is a classic WordPress theme that packages the Tailwind build (`assets/css/tethys.css`) and the three page layouts you mocked up (front page / Igzier file, characters, books).

## Files

- `front-page.php` – renders the Igzier character file automatically when the site front page is set to "A static page" pointing to the page using this template.
- `page-characters.php` – select **Tethys Characters** template while editing the "Characters" page.
- `page-books.php` – select **Tethys Books** template while editing the "Books" page.
- `page-contact.php` – select **Tethys Contact** for your contact page.
- `page-real-science.php` – select **Tethys Real Science** for the research/behind-the-scenes science page.
- `page-comments.php` – select **Tethys Comments** to showcase reader notes & capture new ones.
- `assets/css/tethys.css` – compiled Tailwind output generated from `src/styles.css` in your prototype folder.

## Installing

1. Compress the `tethys-theme` folder into `tethys-theme.zip`.
2. In WordPress, visit **Appearance → Themes → Add New → Upload Theme**, choose the zip, and activate.
3. Create three pages: Home/Igzier, Characters, and Books. Assign the Characters/Books templates where indicated. Set Home as the front page under **Settings → Reading**.

Whenever you adjust the design locally, run `npm run build`, copy the freshly-generated `public/tethys.css` into `tethys-theme/assets/css/tethys.css`, re-zip, and re-upload (or overwrite via SFTP).
