--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.0
-- Dumped by pg_dump version 9.5.0

-- Started on 2016-02-03 16:57:23 ICT

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 7 (class 2615 OID 17035)
-- Name: sys; Type: SCHEMA; Schema: -; Owner: startup
--

CREATE SCHEMA sys;


ALTER SCHEMA sys OWNER TO startup;

--
-- TOC entry 194 (class 3079 OID 12395)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2232 (class 0 OID 0)
-- Dependencies: 194
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 182 (class 1259 OID 17027)
-- Name: account; Type: TABLE; Schema: public; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    code character varying(64) NOT NULL,
    name character varying(256)
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 181 (class 1259 OID 17025)
-- Name: account_id_seq; Type: SEQUENCE; Schema: public; Owner: startup
--

CREATE SEQUENCE account_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE account_id_seq OWNER TO startup;

--
-- TOC entry 2233 (class 0 OID 0)
-- Dependencies: 181
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


SET search_path = sys, pg_catalog;

--
-- TOC entry 184 (class 1259 OID 17038)
-- Name: account; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    id_account bigint NOT NULL
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 183 (class 1259 OID 17036)
-- Name: account_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE account_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE account_id_seq OWNER TO startup;

--
-- TOC entry 2234 (class 0 OID 0)
-- Dependencies: 183
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


--
-- TOC entry 193 (class 1259 OID 17131)
-- Name: accountrole; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE accountrole (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    role character varying(64) NOT NULL
);


ALTER TABLE accountrole OWNER TO startup;

--
-- TOC entry 192 (class 1259 OID 17129)
-- Name: accountrole_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE accountrole_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE accountrole_id_seq OWNER TO startup;

--
-- TOC entry 2235 (class 0 OID 0)
-- Dependencies: 192
-- Name: accountrole_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE accountrole_id_seq OWNED BY accountrole.id;


--
-- TOC entry 189 (class 1259 OID 17088)
-- Name: client; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE client (
    id character varying NOT NULL,
    id_sys_account bigint NOT NULL,
    secret character varying(128)
);


ALTER TABLE client OWNER TO startup;

--
-- TOC entry 188 (class 1259 OID 17075)
-- Name: group; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "group" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE "group" OWNER TO startup;

--
-- TOC entry 187 (class 1259 OID 17073)
-- Name: group_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE group_id_seq OWNER TO startup;

--
-- TOC entry 2236 (class 0 OID 0)
-- Dependencies: 187
-- Name: group_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE group_id_seq OWNED BY "group".id;


--
-- TOC entry 191 (class 1259 OID 17110)
-- Name: groupaccount; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE groupaccount (
    id bigint NOT NULL,
    id_sys_group bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE groupaccount OWNER TO startup;

--
-- TOC entry 190 (class 1259 OID 17108)
-- Name: groupaccount_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE groupaccount_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE groupaccount_id_seq OWNER TO startup;

--
-- TOC entry 2237 (class 0 OID 0)
-- Dependencies: 190
-- Name: groupaccount_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE groupaccount_id_seq OWNED BY groupaccount.id;


--
-- TOC entry 186 (class 1259 OID 17053)
-- Name: user; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "user" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    password character varying(128)
);


ALTER TABLE "user" OWNER TO startup;

--
-- TOC entry 185 (class 1259 OID 17051)
-- Name: user_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_id_seq OWNER TO startup;

--
-- TOC entry 2238 (class 0 OID 0)
-- Dependencies: 185
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


SET search_path = public, pg_catalog;

--
-- TOC entry 2055 (class 2604 OID 17030)
-- Name: id; Type: DEFAULT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2056 (class 2604 OID 17041)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- TOC entry 2060 (class 2604 OID 17134)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole ALTER COLUMN id SET DEFAULT nextval('accountrole_id_seq'::regclass);


--
-- TOC entry 2058 (class 2604 OID 17078)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group" ALTER COLUMN id SET DEFAULT nextval('group_id_seq'::regclass);


--
-- TOC entry 2059 (class 2604 OID 17113)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount ALTER COLUMN id SET DEFAULT nextval('groupaccount_id_seq'::regclass);


--
-- TOC entry 2057 (class 2604 OID 17056)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 2213 (class 0 OID 17027)
-- Dependencies: 182
-- Data for Name: account; Type: TABLE DATA; Schema: public; Owner: startup
--

COPY account (id, code, name) FROM stdin;
\.


--
-- TOC entry 2239 (class 0 OID 0)
-- Dependencies: 181
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: public; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2215 (class 0 OID 17038)
-- Dependencies: 184
-- Data for Name: account; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY account (id, id_account) FROM stdin;
\.


--
-- TOC entry 2240 (class 0 OID 0)
-- Dependencies: 183
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- TOC entry 2224 (class 0 OID 17131)
-- Dependencies: 193
-- Data for Name: accountrole; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY accountrole (id, id_sys_account, role) FROM stdin;
\.


--
-- TOC entry 2241 (class 0 OID 0)
-- Dependencies: 192
-- Name: accountrole_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('accountrole_id_seq', 1, false);


--
-- TOC entry 2220 (class 0 OID 17088)
-- Dependencies: 189
-- Data for Name: client; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY client (id, id_sys_account, secret) FROM stdin;
\.


--
-- TOC entry 2219 (class 0 OID 17075)
-- Dependencies: 188
-- Data for Name: group; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "group" (id, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2242 (class 0 OID 0)
-- Dependencies: 187
-- Name: group_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('group_id_seq', 1, false);


--
-- TOC entry 2222 (class 0 OID 17110)
-- Dependencies: 191
-- Data for Name: groupaccount; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY groupaccount (id, id_sys_group, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2243 (class 0 OID 0)
-- Dependencies: 190
-- Name: groupaccount_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('groupaccount_id_seq', 1, false);


--
-- TOC entry 2217 (class 0 OID 17053)
-- Dependencies: 186
-- Data for Name: user; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "user" (id, id_sys_account, password) FROM stdin;
\.


--
-- TOC entry 2244 (class 0 OID 0)
-- Dependencies: 185
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('user_id_seq', 1, false);


SET search_path = public, pg_catalog;

--
-- TOC entry 2062 (class 2606 OID 17034)
-- Name: account_code_key; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_code_key UNIQUE (code);


--
-- TOC entry 2064 (class 2606 OID 17032)
-- Name: account_pkey; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2066 (class 2606 OID 17067)
-- Name: account_id_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_key UNIQUE (id_account);


--
-- TOC entry 2068 (class 2606 OID 17043)
-- Name: account_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- TOC entry 2087 (class 2606 OID 17138)
-- Name: accountrole_id_sys_account_role_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_role_key UNIQUE (id_sys_account, role);


--
-- TOC entry 2089 (class 2606 OID 17136)
-- Name: accountrole_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_pkey PRIMARY KEY (id);


--
-- TOC entry 2078 (class 2606 OID 17097)
-- Name: client_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2080 (class 2606 OID 17095)
-- Name: client_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id);


--
-- TOC entry 2074 (class 2606 OID 17082)
-- Name: group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2076 (class 2606 OID 17080)
-- Name: group_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_pkey PRIMARY KEY (id);


--
-- TOC entry 2083 (class 2606 OID 17117)
-- Name: groupaccount_id_sys_group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_id_sys_account_key UNIQUE (id_sys_group, id_sys_account);


--
-- TOC entry 2085 (class 2606 OID 17115)
-- Name: groupaccount_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_pkey PRIMARY KEY (id);


--
-- TOC entry 2070 (class 2606 OID 17060)
-- Name: user_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2072 (class 2606 OID 17058)
-- Name: user_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- TOC entry 2090 (class 1259 OID 17144)
-- Name: accountrole_role_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX accountrole_role_idx ON accountrole USING btree (role);


--
-- TOC entry 2081 (class 1259 OID 17128)
-- Name: groupaccount_id_sys_account_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX groupaccount_id_sys_account_idx ON groupaccount USING btree (id_sys_account);


--
-- TOC entry 2091 (class 2606 OID 17068)
-- Name: account_id_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_fkey FOREIGN KEY (id_account) REFERENCES public.account(id) ON DELETE CASCADE;


--
-- TOC entry 2097 (class 2606 OID 17139)
-- Name: accountrole_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2094 (class 2606 OID 17098)
-- Name: client_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2093 (class 2606 OID 17103)
-- Name: group_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2096 (class 2606 OID 17123)
-- Name: groupaccount_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2095 (class 2606 OID 17118)
-- Name: groupaccount_id_sys_group_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_fkey FOREIGN KEY (id_sys_group) REFERENCES "group"(id) ON DELETE CASCADE;


--
-- TOC entry 2092 (class 2606 OID 17061)
-- Name: user_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2231 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-02-03 16:57:24 ICT

--
-- PostgreSQL database dump complete
--

