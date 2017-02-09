This project is based on slim microframework of PHP.


Steps - 
1 - Take clone of this project.
2 - Start local web server using - php -S localhost:8888 
3 - There are 4 apis 
	- http://localhost:8888/public/task/getCheapestList      //for cheapest sorted list
	- http://localhost:8888/public/task/getExpensiveList     //for expensive sorted list
	- http://localhost:8888/public/task/getCheapestProductIdBasedList   //for cheapest list based on product ids
	- http://localhost:8888/public/task/getExpensiveProductIdBasedList  //for expensive list based on product ids


Assumptions - 

Cheapest and Expensive list is prepared based on price per gram of product.
Product id values validation assumes product ids as numeric values.

