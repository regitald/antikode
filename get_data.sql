SELECT
    brands.id AS brand_id,
	brands.name as brand_name,
    outlets_data.name,
    outlets_data.address,
    outlets_data.longitude,
    outlets_data.latitude,
    ROUND(outlets_data.distance,2) as distance,
    COALESCE(products_data.total_products, 0 ) as total_products
FROM
brands
LEFT JOIN (
    SELECT
        outlets.brand_id,
        outlets.name,
        outlets.address,
        outlets.longitude,
        outlets.latitude,
		(6371 * acos( cos( radians(-6.175387) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(106.8226681)) + sin(radians(-6.175387)) * sin( radians(latitude)))) AS distance
    FROM outlets
) AS outlets_data on brands.id=outlets_data.brand_id
LEFT JOIN (
    SELECT
		products.brand_id,
		count(products.id) as total_products
    FROM products
) AS products_data on brands.id=products_data.brand_id
ORDER BY distance;
