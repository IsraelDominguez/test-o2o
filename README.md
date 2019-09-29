# Deploy App for Test

You need to follow this steps to run the app.

Is recommended to have installed to run the app Docker and Docker Compose. Composer is optional, but is recommended too.

## Steps

1. Clone or Download from Git

    git@github.com:IsraelDominguez/test-o2o.git

2. Up Docker Container

        docker-compose up -d

3. Update project dependencies with the installed Composer
    
    `dcp` is a bash script to help us with docker interactions
    
    + If you have bash, you can execute composer from webserver container
    
            ./dcp composer install
    
    + From your installed composer
    
            composer install

4. Test App Api, a Postman export with examples is located in: 

    ./o2o-Test.postman_collection.json


5. The Api routes generated for this test app are:

        ./dcp c debug:router

| Name | Method | Scheme | Host | Path |
| ------ | ---- | --------- | -------| ------- |
| full_search | GET | ANY | ANY | /recipe/search?text=XX&ingredientes=YY,ZZ&page=1
| search_by_ingredients | POST | ANY | ANY | /recipe/ingredients/{ingredients}
| search_by_text | PATCH | ANY | ANY | /recipe/searchByTitle/{text}


6. The PHPUnit results

        PHPUnit 7.4.5 by Sebastian Bergmann and contributors.

        Testing Project O2O Tests
        .......................                                          24 / 24 (100%)

        Time: 4.32 seconds, Memory: 30.00 MB

        OK (24 tests, 114 assertions)


7. A copy of test covarage is in public folder, only for your review in this folder:

        /public/coverage

http://localhost/coverage/index.html

8. Full Search Api result

    http://localhost/recipe/search?text=pesto&ingredients=pesto,garlic&page=2
        
        {
            "recipes": [
                {
                    "title": "Grilled Bell Peppers Stuffed With Basil Pesto and Boccocini Chee",
                    "href": "http://www.recipezaar.com/Grilled-Peppers-With-Pesto-and-Boccocini-Cheese-289416",
                    "ingredients": [
                        "pesto",
                        "garlic",
                        "mozzarella cheese",
                        "olive oil",
                        "salt",
                        "bell pepper"
                    ],
                    "thumbnail": "http://img.recipepuppy.com/711863.jpg"
                },
                {
                    "title": "Pesto Chicken Florentine",
                    "href": "http://allrecipes.com/Recipe/Pesto-Chicken-Florentine/Detail.aspx",
                    "ingredients": [
                        "chicken",
                        "garlic",
                        "olive oil",
                        "pesto",
                        "romano cheese",
                        "spinach"
                    ],
                    "thumbnail": "http://img.recipepuppy.com/22266.jpg"
                },
                ......
            ]
        }