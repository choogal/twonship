create table factory(
	id serial primary key,
	name varchar(255)
);

create table items (
	id serial primary key,
	fk_factory_id integer,
	name varchar(255),
	valor integer,
	make_time integer,
	is_resource boolean	
);

create index items_valor_idx on items (valor);
create index items_make_time_idx on items (make_time);
create index items_is_resource_idx on items (is_resource);
create index items_fk_factory_id_idx on items (fk_factory_id);
ALTER TABLE items ADD FOREIGN KEY (fk_factory_id) REFERENCES factory (id) ON UPDATE CASCADE ON DELETE SET NULL;	

create table item_recipe (
	id serial primary key,
	fk_items_id integer,
	fk_recipe_id integer,
	amount integer default 1
);

create index item_recipe_fk_items_id_idx on item_recipe (fk_items_id);
create index item_recipe_fk_recipe_id_idx on item_recipe (fk_recipe_id);

ALTER TABLE item_recipe ADD FOREIGN KEY (fk_items_id) REFERENCES items (id) ON UPDATE CASCADE ON DELETE SET NULL;	
ALTER TABLE item_recipe ADD FOREIGN KEY (fk_recipe_id) REFERENCES items (id) ON UPDATE CASCADE ON DELETE SET NULL;	