# d3.wordpress
A concept for embedding d3 visualizations in your wordpress blog

#How to
It's pretty straight forward and i put loads of comments into to example code.
The idea is to have a wordpress short-code which is integrated through the code in functions.php.
Whenever a d3 short-code is found in the website the system creates a div as a placeholder as well as setting a variable.
This variable gets picked up in the javascript bit that has to be placed at the end of your website, see footer.php.
This script checks which javascript files to load and initiates the d3 code. In order for this to work, you need to follow the guidelines for reusable d3-code. An example for this can be found in js/barchart.js.
Once setup its pretty easy to add d3 visualizations to any page on your wordpress site. The system even has an option to pass parameters down to the d3 code from the short-code.

#Future
Of course adding this directly into your wordpress theme is not ideal. If somebody could turn this into a widget, so people don't need to paste this code into their theme files, that would be nice! :)
