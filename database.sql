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


create table customer (
    id int primary key auto_increment,
    firstname varchar(50) not null,
    lastname varchar(50) not null,
    address varchar(50) not null,
    zip varchar(10) not null,
    city varchar(30) not null
);

create table `order` (
	id int primary key auto_increment,
	order_date timestamp DEFAULT current_timestamp,
    customer_id int not null,
	index customer_id(customer_id),
	foreign key (customer_id) references customer(id)
	on delete restrict
);


create table order_row(
    order_id int not null,
	index order_id(order_id),
	foreign key (order_id) references `order`(id) on delete restrict,
 	product_id int not null,
	index product_id(product_id),
	foreign key (product_id) references product(id) on delete restrict
);


insert into category(name) value ('Kahvi');
insert into category(name) value ('Tee');
insert into category(name) value ('Muut');

insert into product(name, price, image, category_id) values ('Joulukahvi', 10, 'Kahvi1.jpg', 1);
insert into product(name, price, image, category_id) values ('Tummapaahto luomukahvi', 12, 'Kahvi2.jpg', 1);
insert into product(name, price, image, category_id) values ('Suklaakahvi', 9, 'Kahvi3.jpg', 1);
insert into product(name, price, image, category_id) values ('Karamellikahvi', 11, 'Kahvi4.jpg', 1);
insert into product(name, price, image, category_id) values ('Appelsiinikahvi', 13, 'Kahvi55.jpg', 1);
insert into product(name, price, image, category_id) values ('Chai', 5, 'Tee11.jpg', 2);
insert into product(name, price, image, category_id) values ('Musta tee', 3, 'Tee2.jpg', 2);
insert into product(name, price, image, category_id) values ('Kofeiiniton musta tee', 4, 'Tee3.jpg', 2);
insert into product(name, price, image, category_id) values ('Vihre?? tee', 3, 'Tee4.jpg', 2);
insert into product(name, price, image, category_id) values ('Rooibos', 5, 'Tee5.jpg', 2);
insert into product(name, price, image, category_id) values ('Inkiv????ri vihre?? tee', 5, 'Tee6.jpg', 2);
insert into product(name, price, image, category_id) values ('Sininen ter??lehti tee', 6, 'Tee7.jpg', 2);
insert into product(name, price, image, category_id) values ('Vanha kahvimylly', 20, 'Kahvimylly1.jpg', 3);
insert into product(name, price, image, category_id) values ('Uusi kahvimylly', 25, 'Kahvimylly2.jpg', 3);
insert into product(name, price, image, category_id) values ('Koffie', 4, 'Kahvi100.jpg', 1);
insert into product(name, price, image, category_id) values ('Klassikkokahvi', 4, 'Kahvi101.jpg', 1);
insert into product(name, price, image, category_id) values ('Lipton Peach and Mango', 3, 'Tee19.jpg', 2);
insert into product(name, price, image, category_id) values ('Klassinen kahvimuki', 3, 'kahvimuki.jpg', 3);
insert into product(name, price, image, category_id) values ('Ruusu teekannu', 3, 'teekannu.jpg', 3);
insert into product(name, price, image, category_id) values ('Klassinen teekannu', 3, 'teekannu1.jpg', 3);
insert into product(name, price, image, category_id) values ('Ruusuinen teekuppi', 3, 'teekuppi.jpg', 3);
insert into product(name, price, image, category_id) values ('Klassinen teekuppi', 3, 'teekuppi1.jpg', 3);
insert into product(name, price, image, category_id) values ('Laadukkaita kahvipapuja', 8, 'kahvipapu.jpg', 1);
insert into product(name, price, image, category_id) values ('Wanhanajan kahvi', 10, 'saksakahvi.jpg', 1);
