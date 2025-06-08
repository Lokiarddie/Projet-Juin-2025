--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2
-- Dumped by pg_dump version 17.2

-- Started on 2025-06-08 04:54:25

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 73751)
-- Name: admin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admin (
    id_admin integer NOT NULL,
    nom_admin text NOT NULL,
    login_admin text NOT NULL,
    password_admin text NOT NULL
);


ALTER TABLE public.admin OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 73756)
-- Name: admin_id_admin_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.admin_id_admin_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.admin_id_admin_seq OWNER TO postgres;

--
-- TOC entry 4901 (class 0 OID 0)
-- Dependencies: 218
-- Name: admin_id_admin_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.admin_id_admin_seq OWNED BY public.admin.id_admin;


--
-- TOC entry 220 (class 1259 OID 90244)
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id integer NOT NULL,
    nom character varying(100) NOT NULL,
    prenom character varying(100),
    email character varying(150) NOT NULL,
    password text NOT NULL,
    adresse text,
    date_inscription timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    login character varying(100)
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 90243)
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;

--
-- TOC entry 4902 (class 0 OID 0)
-- Dependencies: 219
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- TOC entry 224 (class 1259 OID 90267)
-- Name: commandes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.commandes (
    id integer NOT NULL,
    client_id integer NOT NULL,
    date_commande timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    statut character varying(50) DEFAULT 'en attente'::character varying
);


ALTER TABLE public.commandes OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 90266)
-- Name: commandes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.commandes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.commandes_id_seq OWNER TO postgres;

--
-- TOC entry 4903 (class 0 OID 0)
-- Dependencies: 223
-- Name: commandes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.commandes_id_seq OWNED BY public.commandes.id;


--
-- TOC entry 225 (class 1259 OID 90280)
-- Name: commandes_produits; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.commandes_produits (
    commande_id integer NOT NULL,
    produit_id integer NOT NULL,
    quantite integer NOT NULL
);


ALTER TABLE public.commandes_produits OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 90256)
-- Name: produits; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produits (
    id integer NOT NULL,
    type character varying(20) NOT NULL,
    nom character varying(100) NOT NULL,
    description text,
    prix numeric(6,2) NOT NULL,
    image character varying(255),
    categorie character varying(50),
    quantite_stock integer DEFAULT 0,
    CONSTRAINT produits_type_check CHECK (((type)::text = ANY ((ARRAY['plante'::character varying, 'accessoire'::character varying])::text[])))
);


ALTER TABLE public.produits OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 90255)
-- Name: produits_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produits_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produits_id_seq OWNER TO postgres;

--
-- TOC entry 4904 (class 0 OID 0)
-- Dependencies: 221
-- Name: produits_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produits_id_seq OWNED BY public.produits.id;


--
-- TOC entry 4714 (class 2604 OID 73757)
-- Name: admin id_admin; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin ALTER COLUMN id_admin SET DEFAULT nextval('public.admin_id_admin_seq'::regclass);


--
-- TOC entry 4715 (class 2604 OID 90247)
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- TOC entry 4719 (class 2604 OID 90270)
-- Name: commandes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes ALTER COLUMN id SET DEFAULT nextval('public.commandes_id_seq'::regclass);


--
-- TOC entry 4717 (class 2604 OID 90259)
-- Name: produits id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits ALTER COLUMN id SET DEFAULT nextval('public.produits_id_seq'::regclass);


--
-- TOC entry 4887 (class 0 OID 73751)
-- Dependencies: 217
-- Data for Name: admin; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.admin (id_admin, nom_admin, login_admin, password_admin) VALUES (1, 'Superadmin', 'admin', 'admin');


--
-- TOC entry 4890 (class 0 OID 90244)
-- Dependencies: 220
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.clients (id, nom, prenom, email, password, adresse, date_inscription, login) VALUES (1, 'Dupont', 'Jean', 'jean.dupont@example.com', 'motdepasse123', '12 rue des Fleurs\n75000 Paris', '2024-06-08 04:29:15.741069', 'jeandu67');
INSERT INTO public.clients (id, nom, prenom, email, password, adresse, date_inscription, login) VALUES (2, 'Martin', 'Claire', 'claire.martin@example.com', 'secret456', '34 avenue des Champs\n69000 Lyon', '2024-12-08 04:29:15.741069', 'clairon');
INSERT INTO public.clients (id, nom, prenom, email, password, adresse, date_inscription, login) VALUES (3, 'Durand', 'Paul', 'paul.durand@example.com', 'paul789', '56 boulevard Voltaire\n13000 Marseille', '2025-04-08 04:29:15.741069', 'paulette');
INSERT INTO public.clients (id, nom, prenom, email, password, adresse, date_inscription, login) VALUES (4, 'tonnelle', 'laurine', 'laurine.tonnelle@gmail.com', '1236', 'Chaussée de Lille 192', '2025-06-08 04:30:44', 'Lokiarddie');


--
-- TOC entry 4894 (class 0 OID 90267)
-- Dependencies: 224
-- Data for Name: commandes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.commandes (id, client_id, date_commande, statut) VALUES (1, 1, '2025-05-29 04:29:15.741069', 'livrée');
INSERT INTO public.commandes (id, client_id, date_commande, statut) VALUES (2, 1, '2025-06-05 04:29:15.741069', 'en attente');
INSERT INTO public.commandes (id, client_id, date_commande, statut) VALUES (3, 2, '2025-05-19 04:29:15.741069', 'annulée');
INSERT INTO public.commandes (id, client_id, date_commande, statut) VALUES (4, 4, '2025-06-08 04:31:11.855354', 'en attente');


--
-- TOC entry 4895 (class 0 OID 90280)
-- Dependencies: 225
-- Data for Name: commandes_produits; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.commandes_produits (commande_id, produit_id, quantite) VALUES (1, 1, 1);
INSERT INTO public.commandes_produits (commande_id, produit_id, quantite) VALUES (1, 3, 2);
INSERT INTO public.commandes_produits (commande_id, produit_id, quantite) VALUES (2, 2, 1);
INSERT INTO public.commandes_produits (commande_id, produit_id, quantite) VALUES (3, 4, 5);


--
-- TOC entry 4892 (class 0 OID 90256)
-- Dependencies: 222
-- Data for Name: produits; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (1, 'plante', 'Ficus Lyrata', 'plante dinterieur très populaire avec de grandes feuilles', 29.99, 'ficus.jpg', 'plantes vertes', 15);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (2, 'plante', 'Monstera Deliciosa', 'Plante tropicale avec feuilles découpées', 35.50, 'monstera.jpg', 'plantes vertes', 20);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (3, 'accessoire', 'Arrosoir en métal', 'Arrosoir de 2L, facile à utiliser', 12.00, 'arrosoir.jpg', 'arrosage', 50);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (4, 'accessoire', 'Terreau universel', 'Terreau adapté pour toutes les plantes d\intérieur', 8.99, 'terreau.jpg', 'engrais', 100);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (5, 'plante', 'Cactus Echinopsis', 'Petit cactus avec de jolies fleurs roses', 15.00, 'cactus.jpg', 'plantes grasses', 30);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (6, 'plante', 'Succulente Aloe Vera', 'Plante médicinale facile à entretenir', 18.50, 'aloe_vera.jpg', 'plantes grasses', 25);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (7, 'plante', 'Palmier Areca', 'Palmier d’intérieur élégant et lumineux', 45.00, 'areca.jpg', 'plantes vertes', 10);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (8, 'plante', 'Orchidée Phalaenopsis', 'Orchidée blanche délicate en pot décoratif', 39.90, 'orchidee.jpg', 'plantes fleuries', 8);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (9, 'plante', 'Lavande en pot', 'Plante aromatique parfumée et colorée', 12.00, 'lavande.jpg', 'plantes aromatiques', 20);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (10, 'accessoire', 'Pot en terre cuite', 'Pot de 15cm de diamètre, idéal pour plantes d’intérieur', 9.50, 'pot_terre_cuite.jpg', 'pots', 60);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (11, 'accessoire', 'Engrais liquide', 'Engrais pour plantes d’intérieur, dosage facile', 14.99, 'engrais_liquide.jpg', 'engrais', 40);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (12, 'accessoire', 'Graines de tournesol', 'Graines pour nourrir les oiseaux du jardin', 5.00, 'graines_tournesol.jpg', 'jardin', 100);
INSERT INTO public.produits (id, type, nom, description, prix, image, categorie, quantite_stock) VALUES (13, 'accessoire', 'Gants de jardinage', 'Gants résistants pour protéger vos mains', 7.50, 'gants_jardinage.jpg', 'outils', 50);


--
-- TOC entry 4905 (class 0 OID 0)
-- Dependencies: 218
-- Name: admin_id_admin_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admin_id_admin_seq', 1, false);


--
-- TOC entry 4906 (class 0 OID 0)
-- Dependencies: 219
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 4, true);


--
-- TOC entry 4907 (class 0 OID 0)
-- Dependencies: 223
-- Name: commandes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.commandes_id_seq', 4, true);


--
-- TOC entry 4908 (class 0 OID 0)
-- Dependencies: 221
-- Name: produits_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produits_id_seq', 14, true);


--
-- TOC entry 4724 (class 2606 OID 73759)
-- Name: admin admin_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin
    ADD CONSTRAINT admin_pkey PRIMARY KEY (id_admin);


--
-- TOC entry 4726 (class 2606 OID 90254)
-- Name: clients clients_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_email_key UNIQUE (email);


--
-- TOC entry 4728 (class 2606 OID 90252)
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- TOC entry 4730 (class 2606 OID 90296)
-- Name: clients clients_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_username_key UNIQUE (login);


--
-- TOC entry 4736 (class 2606 OID 90274)
-- Name: commandes commandes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes
    ADD CONSTRAINT commandes_pkey PRIMARY KEY (id);


--
-- TOC entry 4738 (class 2606 OID 90284)
-- Name: commandes_produits commandes_produits_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_produits
    ADD CONSTRAINT commandes_produits_pkey PRIMARY KEY (commande_id, produit_id);


--
-- TOC entry 4734 (class 2606 OID 90265)
-- Name: produits produits_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT produits_pkey PRIMARY KEY (id);


--
-- TOC entry 4732 (class 2606 OID 90298)
-- Name: clients unique_username; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT unique_username UNIQUE (login);


--
-- TOC entry 4739 (class 2606 OID 90275)
-- Name: commandes commandes_client_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes
    ADD CONSTRAINT commandes_client_id_fkey FOREIGN KEY (client_id) REFERENCES public.clients(id) ON DELETE CASCADE;


--
-- TOC entry 4740 (class 2606 OID 90285)
-- Name: commandes_produits commandes_produits_commande_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_produits
    ADD CONSTRAINT commandes_produits_commande_id_fkey FOREIGN KEY (commande_id) REFERENCES public.commandes(id) ON DELETE CASCADE;


--
-- TOC entry 4741 (class 2606 OID 90290)
-- Name: commandes_produits commandes_produits_produit_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_produits
    ADD CONSTRAINT commandes_produits_produit_id_fkey FOREIGN KEY (produit_id) REFERENCES public.produits(id);


-- Completed on 2025-06-08 04:54:25

--
-- PostgreSQL database dump complete
--

