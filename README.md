# AvatarGenerate
This script is almost an exact replica of the version inside of an r63b Habbo client. The script also has numerous capabilities designed into it, which Xenon's did not. Some of those features include:

- A PHP script that accompanies the javascript to produce a JSON of the palettes and colors within the figuredata this means that when you upgrade/downgrade your figuredata you can keep your avatar generator in-sync so that no errors are produced by clothes that are not present within your SWFs.
- You may import a default figure by using the 'AG.importFigure()' method.
- Correct colors! The script will check the figure data to see which colors are made available to that specific set type ( i.e. "hr", "ch", "ca" ).

At some point within the future, I will more than likely create a PHP script to remove the need for habbo-imaging directly from Habbo. However, I do not currently posses the time. I believe the Tsuka's habbo-imaging script does a good enough job if you wish to use that.

I will NOT be offering support on how to put this script into your CMS. However, if you do notice an issue with the script - please feel free to post the bug on GitHub.

** NOTE FOR DEVELOPERS ** - The javascript and PHP script are both heavily documented, so if you would like to understand more on how the scripts work - just read through them.
