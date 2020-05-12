create database ordersystem;

grant all on ordersystem.* to 524user@localhost identified by '8fa28af6';

use ordersystem

create table users (
  CD int not null primary key,
  category int not null,
  name varchar(50),
  unit int not null,
  quantity int not null,
  rank varchar(255)
) ;

insert into users (CD, category, name, unit, quantity, rank) values ();
