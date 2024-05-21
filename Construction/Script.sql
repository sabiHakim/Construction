create  database construction;
 create  table login(
            id serial primary key ,
            nom varchar(25),
            mdp text,
            role int
        );
insert into  login(nom,mdp,role)values('admin','admin',0);
--
create table  client(
               id  serial PRIMARY KEY ,
               num varchar(50)
            )
--
create  table  uniter(
              id  serial PRIMARY KEY ,
              nom varchar(25)
);
insert into uniter(nom) values ('m3');
insert into uniter(nom) values ('fft');
insert into uniter(nom) values ('m2');
--
create  table  travauxx(
          id  serial PRIMARY KEY ,
          code_travaux varchar(25),
          nomTravaux varchar(100)
);
-- INSERT INTO travauxx (code_travaux,nomTravaux) VALUES ('001','Travaux preparatoire');
-- INSERT INTO travauxx (code_travaux,nomTravaux) VALUES ('002','Travaux terrassement');
-- INSERT INTO travauxx (code_travaux,nomTravaux) VALUES ('003','Travail infrastructure');
--
create table maisons(
                        id   serial PRIMARY KEY,
                        nom VARCHAR(150),
                        Description text,
                        surface double precision,
                        dureConstruction int
);
-- INSERT INTO  maisons(nom,Description,surface,dureConstruction)values('M1',23456,'d1',5);
-- INSERT INTO  maisons(nom,Description,surface,dureConstruction)values('M2',3456,'d2',2);
--
create  table  Details_travaux(
    id serial primary key not null ,
        Maisonid  int references maisons(id) not null ,
        idTravaux int references  travauxx(id) not null ,
        unite int references uniter(id),
        qte double precision,
        pu double precision not null
);
-- insert into Details_travaux (Maisonid,idTravaux,designation,unite,qte,pu)values(1,1,'mur soutenement',1,2,190000.00);
-- insert into Details_travaux (Maisonid,idTravaux,designation,unite,qte,pu) values(1,2,'Decapage terrain',3,2,311448.69);
-- insert into Details_travaux (Maisonid,idTravaux,designation,unite,qte,pu) values(1,3,'maconnerie',1,2,180000);
--
-- insert into Details_travaux (Maisonid,idTravaux,designation,unite,qte,pu) values(2,1,'mur soutenement',1,1,170000.00);
-- insert into Details_travaux (Maisonid,idTravaux,designation,unite,qte,pu) values(2,2,'Decapage terrain',3,1,312448.69);
--
create  table  finition(
        id serial primary key not null ,
        nom varchar(20) not null ,
        pourcentage double precision not null
);
-- insert  into finition(nom, pourcentage)  values ('standart',0);
-- insert  into finition(nom, pourcentage)  values ('gold',20);
-- insert  into finition(nom, pourcentage)  values ('premium',60);
-- insert  into finition(nom, pourcentage)  values ('vip',80);
--
-- create  sequence  devis increment by 1 start with  1;
--     id   varchar  PRIMARY KEY default 'D'||LPAD(nextval('devis')::TEXT,3,'0'),
create  table  devis_client(
    id serial primary key not null ,
    reference varchar(20) not null ,
    idClient int references client(id) not null ,
    date_devis date not null ,
    Date_Debut_travaux date not null,
    Date_fin date not null,
    idMaison int  references maisons(id) not null ,
    finition int references finition(id) not null ,
    lieu varchar not null ,
    prixTotal FLOAT not null
);
create  table  detail_devis(
    idDevis int references  devis_client(id),
    idTravaux  int references  travauxx(id),
    unite int references uniter(id),
    qte double precision not null,
    pu double precision not null
);
CREATE VIEW vue_devis AS
SELECT
    dc.id AS id,
    dc.idclient,
    dc.date_debut_travaux,
    dc.date_fin,
    dc.idmaison,
    m.nom,
    m.Description,
    m.dureConstruction,
    f.id as idfinition,
    f.nom AS finition,
    dc.prixtotal
FROM devis_client dc
         JOIN maisons m ON dc.idmaison = m.id
         JOIN finition f ON dc.finition = f.id;
--
CREATE VIEW vue_detail_travaux AS
SELECT
    dd.iddevis,
    dd.idtravaux,
    dd.unite,
    dd.qte,
    dd.pu,
    t.code_travaux,
    t.nomtravaux
FROM detail_devis dd
         JOIN travauxx t ON dd.idtravaux = t.id;
--
create  table payement(
        idPayement serial primary key ,
         reference  varchar(25) unique ,
        idDevis int references devis_client(id),
        montant double precision,
        date_payement date
);
create or replace view sumPayement as
       select idDevis, sum(montant) from payement group by idDevis;
--
CREATE VIEW vue_devis_payement AS
SELECT
    vd.id AS id_devis,
    vd.idclient,
    vd.date_debut_travaux,
    vd.date_fin,
    vd.idmaison,
    vd.nom AS nom_maison,
    vd.Description AS description_maison,
    vd.dureConstruction,
    vd.idfinition,
    vd.finition,
    vd.prixtotal,
    p.sum
FROM vue_devis vd
         JOIN sumPayement p ON vd.id = p.idDevis;
--
CREATE VIEW vue_details_travaux AS
SELECT
    dt.maisonid,
    dt.idtravaux,
    t.code_travaux,
    t.nomtravaux,
    dt.unite,
    dt.qte,
    dt.pu
FROM details_travaux dt
         JOIN travauxx t ON dt.idtravaux = t.id;
--
-- SELECT *
-- FROM devis_client
-- WHERE EXTRACT(YEAR FROM date_debut_travaux) = 2024;
--
create  table  csvmaison(
    id serial primary key ,
    type_maison  varchar(25),
    description varchar(250),
    surface double precision,
    code_travaux varchar(25),
    type_travaux varchar(200),
    unite varchar(25) ,
    prix_unitaire  double precision,
    quantite double precision ,
    duree_travaux int
);
create  table csvdevis(
    id serial primary key ,
    client  varchar(50),
     reference varchar(50) unique,
     maison varchar(25),
    finition varchar(25),
    taux_finition double precision,
    datedevis varchar(25),
    datedebut varchar(25),
    lieu varchar(25)
);
create  table csvpayement(
    id serial primary key ,
    ref_devis  varchar(50),
    ref_paiement varchar(50) unique,
    date_paiement varchar(25),
    montant float
);
-- function pgsql
CREATE OR REPLACE FUNCTION generate_maison()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO maisons (nom, description, surface, dureconstruction)
SELECT  type_maison,  description,surface, duree_travaux
FROM (
         SELECT DISTINCT type_maison, surface, description, duree_travaux
         FROM csvmaison
     ) AS unique_maisons;
END;
$$;

CREATE OR REPLACE FUNCTION generate_travaux()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO travauxx (code_travaux,nomtravaux)
SELECT  code_travaux,  type_travaux
FROM (
         SELECT DISTINCT code_travaux, type_travaux
         FROM csvmaison
     ) AS unique_maisons;
END;
$$;

CREATE OR REPLACE FUNCTION generate_unite()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO uniter (nom)
SELECT DISTINCT (unite) FROM csvmaison;
END;
$$;

CREATE OR REPLACE FUNCTION generate_client()
RETURNS VOID
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO client (num)
SELECT DISTINCT client FROM csvdevis;
END;
$$;

CREATE OR REPLACE FUNCTION generate_finition()
RETURNS VOID
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO finition (nom, pourcentage)
SELECT DISTINCT f.finition, f.taux_finition
FROM csvdevis f;
END;
$$;

CREATE OR REPLACE FUNCTION reinitialiser()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
delete from payement;
delete from  detail_devis ;
delete from csvdevis;
delete from csvmaison;
delete from detail_devis;
delete from devis_client ;
delete from Details_travaux ;
delete from finition ;
delete from travauxx ;
delete from maisons ;
delete from uniter ;
delete from client ;

END;
$$;
