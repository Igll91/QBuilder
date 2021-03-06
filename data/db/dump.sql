PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE category_type (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE category (id INTEGER NOT NULL, category_type_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_64C19C1294CCED FOREIGN KEY (category_type_id) REFERENCES category_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE);
INSERT INTO "category" VALUES(1,NULL,'CAT_A');
INSERT INTO "category" VALUES(2,NULL,'CAT_B');
INSERT INTO "category" VALUES(3,NULL,'CAT_C');
CREATE TABLE product (id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price DOUBLE PRECISION NOT NULL, inStock BOOLEAN NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE);
INSERT INTO "product" VALUES(1,1,'PROD_A',23.23,0);
INSERT INTO "product" VALUES(2,2,'Shirt',80.99,0);
INSERT INTO "product" VALUES(3,3,'Book_A',14.0,1);
INSERT INTO "product" VALUES(4,2,'Car_a',120000.0,0);
INSERT INTO "product" VALUES(5,1,'PROD_B',33.0,1);
INSERT INTO "product" VALUES(6,3,'Book_H',92.0,1);
INSERT INTO "product" VALUES(7,3,'Mouse',28.0,0);
CREATE UNIQUE INDEX UNIQ_7452D6E5E237E06 ON category_type (name);
CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name);
CREATE INDEX IDX_64C19C1294CCED ON category (category_type_id);
CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id);
COMMIT;
