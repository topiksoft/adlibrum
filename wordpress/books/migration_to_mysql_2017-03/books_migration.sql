CREATE TABLE IF NOT EXISTS inventory (
	paid int(4) unsigned,
	shippingtype int(4) unsigned,
	reported int(4) unsigned,
	invoiced int(4) unsigned,
	idtransaction int(8) unsigned PRIMARY KEY,
	idbook int(6) unsigned NOT NULL,
	type int(4) unsigned,
	client varchar(150),
	ordernr int(4) unsigned,
	unitnr int(4) unsigned,
	unitprice int(4) unsigned,
	shipping int(4) unsigned,
	postage int(4) unsigned,
	wholesaler int(4) unsigned,
	transactiondate date,
	transactioninfo varchar(300),
	comment varchar(500));

#százalékjelek helyére "01"

CREATE TABLE IF NOT EXISTS costs (
	idcost int(8) unsigned PRIMARY KEY,
	date varchar(20),
	paid int(2) unsigned,
	type varchar(50),
	sum int(8) unsigned,
	description varchar(500),
	bookid int(6) unsigned);

CREATE TABLE IF NOT EXISTS costTypes (
	id int(2) unsigned PRIMARY KEY,
	name varchar(30));
INSERT INTO costTypes VALUES(1,'Egyéb költség');
INSERT INTO costTypes VALUES(2,"Nyomdaköltség");
INSERT INTO costTypes VALUES(3,"Tördelési költség");
INSERT INTO costTypes VALUES(4,"Borítóköltség");
INSERT INTO costTypes VALUES(5,"Postaköltség");
INSERT INTO costTypes VALUES(6,"Korrektúra");
INSERT INTO costTypes VALUES(7,"Jogdíjkifizetés");
INSERT INTO costTypes VALUES(8,"Szerzői befizetés");
INSERT INTO costTypes VALUES(9,"Eladásból bevétel");
INSERT INTO costTypes VALUES(10,"Egyéb bevétel");

CREATE TABLE IF NOT EXISTS costPaid (
	id int(2) unsigned PRIMARY KEY,
	name varchar(30));
INSERT INTO costPaid VALUES(1,"Fizetendő");
INSERT INTO costPaid VALUES(2,"Fizetett");
INSERT INTO costPaid VALUES(3,"Belső költség");

CREATE TABLE IF NOT EXISTS books (
	saleprice int(6) unsigned, 
	language int(2) unsigned, 
	extrainfo varchar(300), 
	coverfile varchar(100), 
	weight int(6) unsigned, 
	onlineshopwindow int(6) unsigned, 
	onlineshop int(6) unsigned, 
	distribution int(6) unsigned, 
	category2 int(6) unsigned, 
	category1 int(6) unsigned, 
	link_googlebooks varchar(200), 
	reported int(6) unsigned, 
	authorprice int(6) unsigned, 
	royaltyreseller int(3) unsigned, 
	royaltywebshop int(3) unsigned, 
	commentcontract varchar(1000), 
	quarter int(6) unsigned, 
	vat int(6) unsigned, 
	printingcost int(6) unsigned, 
	contracted int(6) unsigned, 
	printrun int(6) unsigned, 
	contracttype int(6) unsigned, 
	status_webpage int(6) unsigned, 
	datepubd int(6) unsigned, 
	datepubm int(6) unsigned, 
	datepuby int(6) unsigned, 
	idbook int(6) unsigned PRIMARY KEY, 
	author varchar(160), 
	title varchar(255), 
	isbn varchar(50), 
	publisher int(6) unsigned, 
	publishing varchar(100), 
	pubyear varchar(50), 
	format varchar(20), 
	pages smallint(6), 
	series varchar(255), 
	price int(6), 
	sponsor tinyint(1), 
	addedinfo varchar(255), 
	link_website varchar(150), 
	link_webshop varchar(150), 
	link_bookline varchar(150), 
	link_libri varchar(150), 
	link_lira varchar(150), 
	link_telekiteka varchar(150),
	link_alexandra varchar(150),
	imagename varchar(100),
	extraname varchar(100),
	status tinyint(1),
	status_contract tinyint(1),
	status_copyediting tinyint(1),
	status_dtp tinyint(1),
	status_cover tinyint(1),
	status_printing tinyint(1),
	status_billing tinyint(1),
	date_submission varchar(12),
	date_publication varchar(12),
	author_address varchar(200),
	author_email varchar(100),
	abstractshort varchar(1000),
	blurb varchar(2000),
	comment varchar(2000),
	date_created int(12), 
	date_modified int(12), 
	overdue int(1));


update books set pubyear=pubyear+2007;
ALTER TABLE books ADD COLUMN pubdate date;
update books set datepubd=1 where datepubd=0;
update books set datepubm=1 where datepubm=0;
update books set pubdate=concat(datepuby,"-",datepubm,"-",datepubd);
update books set language=language+1;
update books set distribution=distribution+1;
update books set onlineshop=onlineshop+1;
update books set onlineshopwindow=onlineshopwindow+1;

ALTER TABLE books ADD COLUMN progress int(2);

UPDATE inventory SET wholesaler=5  WHERE client like '%Libri%';
UPDATE inventory SET wholesaler=4  WHERE client like '%Könyvbazár%';
UPDATE inventory SET wholesaler=6  WHERE client like '%KELLO%';
SELECT client,wholesaler FROM inventory WHERE client like '%Libri%';

UPDATE inventory SET paid=paid+1;
UPDATE inventory SET shippingtype=shippingtype+1;
UPDATE inventory SET invoiced=invoiced+1;

