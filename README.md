# ShoppingWeb
MySQL, PHP, HTML, CSS

Have warning message for all possible error scenario

Project description:
Customer can browse the shopping website items. Customer needs to login/register to be able to put items to cart and to check out/purchase items. After registration, customer needs to login. Customer can see account info and purchase cart in the cart.php page. After checkout items, Customer will be directed to the reciept page where account info, item purchase info and the total price shown. Customer can logout.

How to use (localhost):
in the MySQL, create 3 table: purchase, members, and shopCart. Then connect php to the database using connectDB.php. Upload all of the .php file to the folder inside the XAMPP htdocs folder or AMPPS www folder. Open the login.php file in the localhost. The website is ready to use. 

members table is to store information about the users/customers login information. purchase table is for admin to check all of the items each total number of purchase from all of the users. shopCart table is to store purchase information that is the user's ID, items' names, price, quantity, total price, and date of purchase. 

login and shopping cart is stored using SESSION. If user logout, the shopping cart is cleared. 
