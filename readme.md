Для работы нужен php >=8.1
Конфигурация подключения к бд находится в файле /core/config.php
Для работы в бд должны находиться 2 таблицы:
1. для хранения поставок
<code> -- auto-generated definition
   create table shipment
   (
   id           int auto_increment
   primary key,
   number       varchar(30) not null,
   product_name varchar(30) not null,
   quantity     int         not null,
   price        int         not null,
   date         date        not null
   );
</code>
2. для хранения состояния склада
<code>-- auto-generated definition
   create table warehouse
   (
   id           int auto_increment
   primary key,
   product_name varchar(30) not null,
   quantity     int         not null,
   price        int         not null,
   constraint warehouse_product_name_uindex
   unique (product_name)
   );
</code>
Обе таблицы нужно заполнить изначальными данными, указанными в задаче