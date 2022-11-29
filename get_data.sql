-- get name brand
select brands.name from brands;

-- get Outlet name, address, longitude, latitude
select name, address, longitude, latitude from outlets;

-- total product
select count(id) from products;

-- total product  and outlets by brand
select brands.name, 
(select count(*) from outlets where brands.id = outlets.brand_id) as outlets_count, 
(select count(*) from products where brands.id = products.brand_id) as products_count 
from brands;

-- distance outlet from monas
-- lat -6.1753936 | long 106.827186
SELECT id, name, latitude, longitude, (acos(sin(latitude)*sin(-6.1753936)+cos(latitude)*cos(-6.1753936)*cos(106.827186-longitude))*6371) as distance FROM outlets;

SELECT id, name, latitude, longitude, (((acos(sin((latitude*pi()/180)) * sin((-6.1753936*pi()/180)) + cos((latitude*pi()/180)) * cos((-6.1753936*pi()/180)) * cos(((longitude- 106.827186) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance FROM outlets
