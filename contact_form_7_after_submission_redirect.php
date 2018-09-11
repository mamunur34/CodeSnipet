on_sent_ok: "location = 'http://example.com/';"

[SOLUTION]

This solution applies for the the latest version to date contact form 7 2.1

Open "contact-form-7/scripts.js"

and edit the lines to reflect the following..

if (data.onSentOk)
jQuery.each(data.onSentOk, function(i, n) { eval(n) });
if(document.location == "http://sitename.com/donations/"){
location.href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=xxxxxx";
}

http://www.fundmydr.com/thank/

on_sent_ok: "location = 'http://www.fundmydr.com/thank/';"
