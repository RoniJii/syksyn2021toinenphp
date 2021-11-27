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

insert into category(name) value ('Kahvi');
insert into category(name) value ('Tee');
insert into category(name) value ('Muut');


insert into product(name, price, image, category_id) values ('La Golondrina', 10,'kahvi12.jpg', 1);
insert into product(name, price, image, category_id) values ('Eleta', 20, 'kahvi5.jpg', 1);
insert into product(name, price, image, category_id) values ('Kicking Horse', 10,'kahvi7.jpg', 2);
insert into product(name, price, image, category_id) values ('Tempter', 20, 'kahvi8.jpg', 2);
insert into product(name, price, image, category_id) values ('Lipton tee', 20, 'tee1.jpg', 2);