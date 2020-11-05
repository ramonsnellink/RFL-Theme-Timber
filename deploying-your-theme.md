# Deploying Your Theme

Once you are ready to deploy your theme, run `yarn run build` to build your production assets bundle, then run `yarn run archive` to create a zip file of your theme. Locate the zip file in the `package` directory and upload it to your server.

?>If your generated zip file is missing assets that were available to the development server, you probably forgot to specify them in the `packageFiles` section of your wpackio.project.js file.

?>Tailwind CSS includes PurgeCSS. It's set up to check your Twig files and detect which classes you've used, and include only the necessary ones in your production bundle. You can adjust these settings in tailwind.config.js.
