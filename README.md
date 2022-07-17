Process

Task 1
Set up project, with sqlite db , ensure default migrations run and artisan serve is working as expected.

commit with message Ready to begin

Task 1 Complete

Task 2

updating database to allow mutiple fillings on a single order
    -- please note I am more used to mysql so excuse any missued termonology
options : 
    alter column to type set, - I have since found that sqlite does not support this option
        pros : allows multiple unique fillings on an order
        cons : goes against normalisation
    
    Create a many to many relationship table
        pros : allows multiple fillings including mutiple of the same
        cons : more tables to be maintained

    Alter column to text type and add toppings as json string
        pros : allows multiple fillings without extra tables to maintain
        cons : not best practice for databases, goes against normalisation

    Choise 
        Create a many to many relationship table with foreign key constraints.
        this will allow the orders to be created with multiple fillings and has
        flexibility for further expansion such as order of fillings, or quantity of fillings

    steps, drop column fillingId from orders table
    create table order_fillings with columns
        pkId
        orderId
        fillingId
    

    then create the models which will handle db interations

    Task 2 Complete


    End points

    Start with Buns and fillings

    Create a controller for checking available stock of items
    add api routes to point at the controller
    build up basic functions to get a list of buns and a list of fillings

    Google foo to find how to store db results to the cache.


    Login,
    Useing the crew logins to authenticate alter the table to give each crew member a api token
    which can be used for bearer token authentication. not well fleshed out but it works for this application.
    
    create Login action which if the user name and password match will return the bearer token from the request.
    if no bearer token has been generated for the crew member a new bearer token will be issued and saved back to the database


    Add authentication middleware to each of the pre-existing api actions 


    Order End points

    Create basic functions for post patch and delete
    spend too long trying to work out what the pitch http request is meant to be used for before realising that 11pm is no time to be trying to google anything

    create the push method 1st building logic in the controller to get the functionality in place.
    seperate logic into seperate php class to help keep the code clean and improve re-usability throughout the application

    create function steps
        Validate the input
        find the appropriate entries for fillings and bun
        calculate the price
        create the order in the database
        populate the order_fillings table
        return message with order number and price to the client

    patch method
        ensure the record exists
        reusing code already built for the create method pull in the existing order,
        update the bun and fillings with new selected, calculate new price
        update order record in the database
        remove existing order_fillings records and re-populate based on new selected
        Future improvement
            Rather than removing all items from the order fillings table on every patch
            only refresh fillings when fillings have been updated.
            at current multiple of the same filling can be included but they will appear on seperate table rows.
            adding a quantity column to the table may be a way to improve this and possibly make it faster to update only entries that are needed during the patch request.

    Delete method.
        build controller action
        ensure the record exists
        remove order fillings
        remove order
        Soft deletes may be useful in the future so that reporting can be done on the amount of orders that are cancelled.

    Console Commands
        These were created using the php artisan make:command

        I was unsure of what the exact requirement was so I decided to go for 2 options

        total sales :
            gives the user a sum total of the price of all orders in the orders table
            future considerations
                add time stamps to tables so that a timeframe can be given for better reporting
                allow price sum to be filtered by crew member, for employee stat reports
        
        List Order :
            returns a list of all orders, including fillings, buns and which crew member served.
            for this database relations were built up between the orders table, crew table, buns table
            and fillings table through order_fillings.

Testing
    whilst I am not well versed in unit testing I decided that for my own learning it would be best to build unit tests for the functionality I had built,
    I attempted to make tests focused on the orders controller and managed to get decent results.
    I plan to expand my knowledge of testing using this project as I know this is an area I am lacking in 
    and can see a real benifit to testing.