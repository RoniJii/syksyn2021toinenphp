drop database if exists webshop;
create database webshop;
use webshop;

create table category (
    id int primary key auto_increment,
    name varchar(50) not null
);

create table product (
    id int primary key auto_increment,
    name varchar(100) not null,
    price double (10,2) not null,
    image varchar(50),
    category_id int not null,
    index category_id(category_id),
    foreign key (category_id) references category(id)
    on delete restrict
);

insert into category(name) value ('Kahvia');
insert into category(name) value ('Erinlaista kahvia');

insert into product(name, price, category_id) values ('Testi kahvi', 10, 1);
insert into product(name, price, category_id) values ('Testi kahvi2', 20, 1);
insert into product(name, price, category_id) values ('Ernu kahvi', 10, 2);
insert into product(name, price, category_id) values ('Spessu kahvi2', 20, 2);
