Process

Task 1
Set up project, with sqlite db , ensure default migrations run and artisan serve is working as expected.

commit with message Ready to begin

Task 1 Complete

Task 2

updating database to allow mutiple fillings on a single order
    -- please note I am more used to mysql so excuse any missued termonology
options : 
    alter column to type set, 
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

    
    