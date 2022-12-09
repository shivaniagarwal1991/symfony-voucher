
# voucher

This application is resposible for:
- User authentication (JWT)
- CURD for user
- CURD for voucher
- Add Order and
- Get list of order

#### What do I bring to the table beside the expected assignment requirements?
- Creating indexes on field wherever it is needed.
- User management should be a differenet service but for simplicity added in a single project
- I have used the appropriate http response codes as given below.

    **Possible Responses:**
       1. **400** - for bad requests where user didn't pass the required parameters or passed with invalid values etc.
       2. **404** - when we don't find any entity such as fetching the user which doesn't exist
       3. **409** - when there is conflict let's say client wants to create a user which already exists.
       4. **200** - success response
       5. **201** - when entity is created successfully
       6. **401** - when the user is sending an invalid token
       7. **500** - when something went wrong but i wish we never see it :)
       8. **406** - when user try to buy a prodct which is more than his current deposit amount.
    

#### Step to setup the database
- **Option 1** run the below commands from the project root folder to set up a new database
        1. php bin/console doctrine:database:create
        2. php bin/console doctrine:migration:migrate
- **Option 2** Import the PROJECT_ROOT/voucher.sql file to the database with some test data.

#### Steps to run the application

- clone the project
- enter into the root folder of the application
- please run any one of the below commands to run the application
    1. php bin/console server:run 
    2. php -S localhost:8001 -t public 

#### Step to run the test cases
- Please make sure application is up and running.
- Enter into the root folder of the application
- Please run the below commands to run the test cases
    php ./bin/phpunit ./tests/Controller/OrderControllerTest.php
    
#### Import Postman file PROJECT_ROOT/Vouchers.postman_collection.json

#### What can we improve?

- We can create a containerization to run the application. 
- For now single db is being used for main application and test cases. it could be different but as i was also had office work as well therefore left it for now but not a big deal. 
- We can write more detailed unit and integration test cases which will cover all corner cases. I have written some but not all.
- I agree that there are still some of the opportunities to reflector & clean the code along with custom exception handling etc.


README.md
Displaying README.md.
