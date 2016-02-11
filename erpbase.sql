--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.0
-- Dumped by pg_dump version 9.5.0

-- Started on 2016-02-11 17:29:18 ICT

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 6 (class 2615 OID 17287)
-- Name: auth; Type: SCHEMA; Schema: -; Owner: startup
--

CREATE SCHEMA auth;


ALTER SCHEMA auth OWNER TO startup;

--
-- TOC entry 7 (class 2615 OID 17288)
-- Name: sys; Type: SCHEMA; Schema: -; Owner: startup
--

CREATE SCHEMA sys;


ALTER SCHEMA sys OWNER TO startup;

--
-- TOC entry 210 (class 3079 OID 12395)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2337 (class 0 OID 0)
-- Dependencies: 210
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = auth, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 182 (class 1259 OID 17289)
-- Name: accesstoken; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE accesstoken (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE accesstoken OWNER TO startup;

--
-- TOC entry 183 (class 1259 OID 17292)
-- Name: accesstoken_id_seq; Type: SEQUENCE; Schema: auth; Owner: startup
--

CREATE SEQUENCE accesstoken_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE accesstoken_id_seq OWNER TO startup;

--
-- TOC entry 2338 (class 0 OID 0)
-- Dependencies: 183
-- Name: accesstoken_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE accesstoken_id_seq OWNED BY accesstoken.id;


--
-- TOC entry 184 (class 1259 OID 17294)
-- Name: account; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    code character varying(128) NOT NULL,
    client_id character varying(64) NOT NULL,
    user_id character varying(64),
    expires timestamp with time zone NOT NULL
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 185 (class 1259 OID 17297)
-- Name: account_id_seq; Type: SEQUENCE; Schema: auth; Owner: startup
--

CREATE SEQUENCE account_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE account_id_seq OWNER TO startup;

--
-- TOC entry 2339 (class 0 OID 0)
-- Dependencies: 185
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


--
-- TOC entry 186 (class 1259 OID 17299)
-- Name: accountscope; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE accountscope (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL,
    scope character varying(64) NOT NULL
);


ALTER TABLE accountscope OWNER TO startup;

--
-- TOC entry 187 (class 1259 OID 17302)
-- Name: accountscope_id_seq; Type: SEQUENCE; Schema: auth; Owner: startup
--

CREATE SEQUENCE accountscope_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE accountscope_id_seq OWNER TO startup;

--
-- TOC entry 2340 (class 0 OID 0)
-- Dependencies: 187
-- Name: accountscope_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE accountscope_id_seq OWNED BY accountscope.id;


--
-- TOC entry 188 (class 1259 OID 17304)
-- Name: authzcode; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE authzcode (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE authzcode OWNER TO startup;

--
-- TOC entry 189 (class 1259 OID 17307)
-- Name: authzcode_id_seq; Type: SEQUENCE; Schema: auth; Owner: startup
--

CREATE SEQUENCE authzcode_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE authzcode_id_seq OWNER TO startup;

--
-- TOC entry 2341 (class 0 OID 0)
-- Dependencies: 189
-- Name: authzcode_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE authzcode_id_seq OWNED BY authzcode.id;


--
-- TOC entry 190 (class 1259 OID 17309)
-- Name: refreshtoken; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE refreshtoken (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE refreshtoken OWNER TO startup;

--
-- TOC entry 191 (class 1259 OID 17312)
-- Name: refreshtoken_id_seq; Type: SEQUENCE; Schema: auth; Owner: startup
--

CREATE SEQUENCE refreshtoken_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE refreshtoken_id_seq OWNER TO startup;

--
-- TOC entry 2342 (class 0 OID 0)
-- Dependencies: 191
-- Name: refreshtoken_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE refreshtoken_id_seq OWNED BY refreshtoken.id;


SET search_path = public, pg_catalog;

--
-- TOC entry 192 (class 1259 OID 17314)
-- Name: account; Type: TABLE; Schema: public; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    code character varying(64) NOT NULL,
    name character varying(256)
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 193 (class 1259 OID 17317)
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
-- TOC entry 2343 (class 0 OID 0)
-- Dependencies: 193
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


SET search_path = sys, pg_catalog;

--
-- TOC entry 194 (class 1259 OID 17319)
-- Name: account; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    id_account bigint NOT NULL
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 195 (class 1259 OID 17322)
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
-- TOC entry 2344 (class 0 OID 0)
-- Dependencies: 195
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


--
-- TOC entry 196 (class 1259 OID 17324)
-- Name: accountrole; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE accountrole (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    role character varying(64) NOT NULL
);


ALTER TABLE accountrole OWNER TO startup;

--
-- TOC entry 197 (class 1259 OID 17327)
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
-- TOC entry 2345 (class 0 OID 0)
-- Dependencies: 197
-- Name: accountrole_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE accountrole_id_seq OWNED BY accountrole.id;


--
-- TOC entry 198 (class 1259 OID 17329)
-- Name: client; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE client (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    secret character varying(128)
);


ALTER TABLE client OWNER TO startup;

--
-- TOC entry 199 (class 1259 OID 17332)
-- Name: client_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE client_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE client_id_seq OWNER TO startup;

--
-- TOC entry 2346 (class 0 OID 0)
-- Dependencies: 199
-- Name: client_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE client_id_seq OWNED BY client.id;


--
-- TOC entry 200 (class 1259 OID 17334)
-- Name: clientgranttype; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE clientgranttype (
    id bigint NOT NULL,
    id_sys_client bigint NOT NULL,
    granttype character varying(64) NOT NULL
);


ALTER TABLE clientgranttype OWNER TO startup;

--
-- TOC entry 201 (class 1259 OID 17337)
-- Name: clientgranttype_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE clientgranttype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE clientgranttype_id_seq OWNER TO startup;

--
-- TOC entry 2347 (class 0 OID 0)
-- Dependencies: 201
-- Name: clientgranttype_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE clientgranttype_id_seq OWNED BY clientgranttype.id;


--
-- TOC entry 202 (class 1259 OID 17339)
-- Name: clientredirecturi; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE clientredirecturi (
    id bigint NOT NULL,
    id_sys_client bigint NOT NULL,
    uri character varying(256) NOT NULL
);


ALTER TABLE clientredirecturi OWNER TO startup;

--
-- TOC entry 203 (class 1259 OID 17342)
-- Name: clientredirecturl_id_seq; Type: SEQUENCE; Schema: sys; Owner: startup
--

CREATE SEQUENCE clientredirecturl_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE clientredirecturl_id_seq OWNER TO startup;

--
-- TOC entry 2348 (class 0 OID 0)
-- Dependencies: 203
-- Name: clientredirecturl_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE clientredirecturl_id_seq OWNED BY clientredirecturi.id;


--
-- TOC entry 204 (class 1259 OID 17344)
-- Name: group; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "group" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE "group" OWNER TO startup;

--
-- TOC entry 205 (class 1259 OID 17347)
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
-- TOC entry 2349 (class 0 OID 0)
-- Dependencies: 205
-- Name: group_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE group_id_seq OWNED BY "group".id;


--
-- TOC entry 206 (class 1259 OID 17349)
-- Name: groupaccount; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE groupaccount (
    id bigint NOT NULL,
    id_sys_group bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE groupaccount OWNER TO startup;

--
-- TOC entry 207 (class 1259 OID 17352)
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
-- TOC entry 2350 (class 0 OID 0)
-- Dependencies: 207
-- Name: groupaccount_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE groupaccount_id_seq OWNED BY groupaccount.id;


--
-- TOC entry 208 (class 1259 OID 17354)
-- Name: user; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "user" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    password character varying(128)
);


ALTER TABLE "user" OWNER TO startup;

--
-- TOC entry 209 (class 1259 OID 17357)
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
-- TOC entry 2351 (class 0 OID 0)
-- Dependencies: 209
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


SET search_path = auth, pg_catalog;

--
-- TOC entry 2099 (class 2604 OID 17359)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken ALTER COLUMN id SET DEFAULT nextval('accesstoken_id_seq'::regclass);


--
-- TOC entry 2100 (class 2604 OID 17360)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- TOC entry 2101 (class 2604 OID 17361)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope ALTER COLUMN id SET DEFAULT nextval('accountscope_id_seq'::regclass);


--
-- TOC entry 2102 (class 2604 OID 17362)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode ALTER COLUMN id SET DEFAULT nextval('authzcode_id_seq'::regclass);


--
-- TOC entry 2103 (class 2604 OID 17363)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken ALTER COLUMN id SET DEFAULT nextval('refreshtoken_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 2104 (class 2604 OID 17364)
-- Name: id; Type: DEFAULT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2105 (class 2604 OID 17365)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- TOC entry 2106 (class 2604 OID 17366)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole ALTER COLUMN id SET DEFAULT nextval('accountrole_id_seq'::regclass);


--
-- TOC entry 2107 (class 2604 OID 17367)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client ALTER COLUMN id SET DEFAULT nextval('client_id_seq'::regclass);


--
-- TOC entry 2108 (class 2604 OID 17368)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype ALTER COLUMN id SET DEFAULT nextval('clientgranttype_id_seq'::regclass);


--
-- TOC entry 2109 (class 2604 OID 17369)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi ALTER COLUMN id SET DEFAULT nextval('clientredirecturl_id_seq'::regclass);


--
-- TOC entry 2110 (class 2604 OID 17370)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group" ALTER COLUMN id SET DEFAULT nextval('group_id_seq'::regclass);


--
-- TOC entry 2111 (class 2604 OID 17371)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount ALTER COLUMN id SET DEFAULT nextval('groupaccount_id_seq'::regclass);


--
-- TOC entry 2112 (class 2604 OID 17372)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2302 (class 0 OID 17289)
-- Dependencies: 182
-- Data for Name: accesstoken; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY accesstoken (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2352 (class 0 OID 0)
-- Dependencies: 183
-- Name: accesstoken_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('accesstoken_id_seq', 1, false);


--
-- TOC entry 2304 (class 0 OID 17294)
-- Dependencies: 184
-- Data for Name: account; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY account (id, code, client_id, user_id, expires) FROM stdin;
\.


--
-- TOC entry 2353 (class 0 OID 0)
-- Dependencies: 185
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- TOC entry 2306 (class 0 OID 17299)
-- Dependencies: 186
-- Data for Name: accountscope; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY accountscope (id, id_auth_account, scope) FROM stdin;
\.


--
-- TOC entry 2354 (class 0 OID 0)
-- Dependencies: 187
-- Name: accountscope_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('accountscope_id_seq', 1, false);


--
-- TOC entry 2308 (class 0 OID 17304)
-- Dependencies: 188
-- Data for Name: authzcode; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY authzcode (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2355 (class 0 OID 0)
-- Dependencies: 189
-- Name: authzcode_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('authzcode_id_seq', 1, false);


--
-- TOC entry 2310 (class 0 OID 17309)
-- Dependencies: 190
-- Data for Name: refreshtoken; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY refreshtoken (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2356 (class 0 OID 0)
-- Dependencies: 191
-- Name: refreshtoken_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('refreshtoken_id_seq', 1, false);


SET search_path = public, pg_catalog;

--
-- TOC entry 2312 (class 0 OID 17314)
-- Dependencies: 192
-- Data for Name: account; Type: TABLE DATA; Schema: public; Owner: startup
--

COPY account (id, code, name) FROM stdin;
\.


--
-- TOC entry 2357 (class 0 OID 0)
-- Dependencies: 193
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: public; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2314 (class 0 OID 17319)
-- Dependencies: 194
-- Data for Name: account; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY account (id, id_account) FROM stdin;
\.


--
-- TOC entry 2358 (class 0 OID 0)
-- Dependencies: 195
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- TOC entry 2316 (class 0 OID 17324)
-- Dependencies: 196
-- Data for Name: accountrole; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY accountrole (id, id_sys_account, role) FROM stdin;
\.


--
-- TOC entry 2359 (class 0 OID 0)
-- Dependencies: 197
-- Name: accountrole_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('accountrole_id_seq', 1, false);


--
-- TOC entry 2318 (class 0 OID 17329)
-- Dependencies: 198
-- Data for Name: client; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY client (id, id_sys_account, secret) FROM stdin;
\.


--
-- TOC entry 2360 (class 0 OID 0)
-- Dependencies: 199
-- Name: client_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('client_id_seq', 1, false);


--
-- TOC entry 2320 (class 0 OID 17334)
-- Dependencies: 200
-- Data for Name: clientgranttype; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY clientgranttype (id, id_sys_client, granttype) FROM stdin;
\.


--
-- TOC entry 2361 (class 0 OID 0)
-- Dependencies: 201
-- Name: clientgranttype_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('clientgranttype_id_seq', 1, false);


--
-- TOC entry 2322 (class 0 OID 17339)
-- Dependencies: 202
-- Data for Name: clientredirecturi; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY clientredirecturi (id, id_sys_client, uri) FROM stdin;
\.


--
-- TOC entry 2362 (class 0 OID 0)
-- Dependencies: 203
-- Name: clientredirecturl_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('clientredirecturl_id_seq', 1, false);


--
-- TOC entry 2324 (class 0 OID 17344)
-- Dependencies: 204
-- Data for Name: group; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "group" (id, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2363 (class 0 OID 0)
-- Dependencies: 205
-- Name: group_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('group_id_seq', 1, false);


--
-- TOC entry 2326 (class 0 OID 17349)
-- Dependencies: 206
-- Data for Name: groupaccount; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY groupaccount (id, id_sys_group, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2364 (class 0 OID 0)
-- Dependencies: 207
-- Name: groupaccount_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('groupaccount_id_seq', 1, false);


--
-- TOC entry 2328 (class 0 OID 17354)
-- Dependencies: 208
-- Data for Name: user; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "user" (id, id_sys_account, password) FROM stdin;
\.


--
-- TOC entry 2365 (class 0 OID 0)
-- Dependencies: 209
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('user_id_seq', 1, false);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2114 (class 2606 OID 17374)
-- Name: accesstoken_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2116 (class 2606 OID 17376)
-- Name: accesstoken_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_pkey PRIMARY KEY (id);


--
-- TOC entry 2119 (class 2606 OID 17378)
-- Name: account_code_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_code_key UNIQUE (code);


--
-- TOC entry 2122 (class 2606 OID 17380)
-- Name: account_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- TOC entry 2125 (class 2606 OID 17382)
-- Name: accountscope_id_auth_account_scope_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_id_auth_account_scope_key UNIQUE (id_auth_account, scope);


--
-- TOC entry 2127 (class 2606 OID 17384)
-- Name: accountscope_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_pkey PRIMARY KEY (id);


--
-- TOC entry 2129 (class 2606 OID 17386)
-- Name: authzcode_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2131 (class 2606 OID 17388)
-- Name: authzcode_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_pkey PRIMARY KEY (id);


--
-- TOC entry 2133 (class 2606 OID 17390)
-- Name: refreshtoken_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken
    ADD CONSTRAINT refreshtoken_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2135 (class 2606 OID 17392)
-- Name: refreshtoken_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken
    ADD CONSTRAINT refreshtoken_pkey PRIMARY KEY (id);


SET search_path = public, pg_catalog;

--
-- TOC entry 2137 (class 2606 OID 17394)
-- Name: account_code_key; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_code_key UNIQUE (code);


--
-- TOC entry 2139 (class 2606 OID 17396)
-- Name: account_pkey; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2141 (class 2606 OID 17398)
-- Name: account_id_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_key UNIQUE (id_account);


--
-- TOC entry 2143 (class 2606 OID 17400)
-- Name: account_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- TOC entry 2145 (class 2606 OID 17402)
-- Name: accountrole_id_sys_account_role_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_role_key UNIQUE (id_sys_account, role);


--
-- TOC entry 2147 (class 2606 OID 17404)
-- Name: accountrole_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_pkey PRIMARY KEY (id);


--
-- TOC entry 2150 (class 2606 OID 17406)
-- Name: client_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2152 (class 2606 OID 17408)
-- Name: client_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id);


--
-- TOC entry 2155 (class 2606 OID 17410)
-- Name: clientgranttype_id_sys_client_granttype_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_id_sys_client_granttype_key UNIQUE (id_sys_client, granttype);


--
-- TOC entry 2157 (class 2606 OID 17412)
-- Name: clientgranttype_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_pkey PRIMARY KEY (id);


--
-- TOC entry 2159 (class 2606 OID 17414)
-- Name: clientredirecturi_id_sys_client_uri_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi
    ADD CONSTRAINT clientredirecturi_id_sys_client_uri_key UNIQUE (id_sys_client, uri);


--
-- TOC entry 2161 (class 2606 OID 17416)
-- Name: clientredirecturl_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi
    ADD CONSTRAINT clientredirecturl_pkey PRIMARY KEY (id);


--
-- TOC entry 2163 (class 2606 OID 17418)
-- Name: group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2165 (class 2606 OID 17420)
-- Name: group_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_pkey PRIMARY KEY (id);


--
-- TOC entry 2168 (class 2606 OID 17422)
-- Name: groupaccount_id_sys_group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_id_sys_account_key UNIQUE (id_sys_group, id_sys_account);


--
-- TOC entry 2170 (class 2606 OID 17424)
-- Name: groupaccount_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_pkey PRIMARY KEY (id);


--
-- TOC entry 2172 (class 2606 OID 17426)
-- Name: user_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2174 (class 2606 OID 17428)
-- Name: user_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2117 (class 1259 OID 17429)
-- Name: account_client_id_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_client_id_idx ON account USING btree (client_id);


--
-- TOC entry 2120 (class 1259 OID 17430)
-- Name: account_expires_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_expires_idx ON account USING btree (expires);


--
-- TOC entry 2123 (class 1259 OID 17431)
-- Name: account_user_id_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_user_id_idx ON account USING btree (user_id);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2148 (class 1259 OID 17432)
-- Name: accountrole_role_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX accountrole_role_idx ON accountrole USING btree (role);


--
-- TOC entry 2153 (class 1259 OID 17433)
-- Name: clientgranttype_granttype_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX clientgranttype_granttype_idx ON clientgranttype USING btree (granttype);


--
-- TOC entry 2166 (class 1259 OID 17434)
-- Name: groupaccount_id_sys_account_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX groupaccount_id_sys_account_idx ON groupaccount USING btree (id_sys_account);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2175 (class 2606 OID 17435)
-- Name: accesstoken_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2176 (class 2606 OID 17440)
-- Name: accountscope_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2177 (class 2606 OID 17445)
-- Name: authzcode_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2178 (class 2606 OID 17450)
-- Name: refreshtoken_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken
    ADD CONSTRAINT refreshtoken_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


SET search_path = sys, pg_catalog;

--
-- TOC entry 2179 (class 2606 OID 17455)
-- Name: account_id_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_fkey FOREIGN KEY (id_account) REFERENCES public.account(id) ON DELETE CASCADE;


--
-- TOC entry 2180 (class 2606 OID 17460)
-- Name: accountrole_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2181 (class 2606 OID 17465)
-- Name: client_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2182 (class 2606 OID 17470)
-- Name: clientgranttype_id_sys_client_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_id_sys_client_fkey FOREIGN KEY (id_sys_client) REFERENCES client(id_sys_account) ON DELETE CASCADE;


--
-- TOC entry 2183 (class 2606 OID 17475)
-- Name: clientredirecturl_id_sys_client_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi
    ADD CONSTRAINT clientredirecturl_id_sys_client_fkey FOREIGN KEY (id_sys_client) REFERENCES client(id_sys_account) ON DELETE CASCADE;


--
-- TOC entry 2184 (class 2606 OID 17480)
-- Name: group_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2185 (class 2606 OID 17485)
-- Name: groupaccount_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2186 (class 2606 OID 17490)
-- Name: groupaccount_id_sys_group_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_fkey FOREIGN KEY (id_sys_group) REFERENCES "group"(id) ON DELETE CASCADE;


--
-- TOC entry 2187 (class 2606 OID 17495)
-- Name: user_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2336 (class 0 OID 0)
-- Dependencies: 8
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-02-11 17:29:19 ICT

--
-- PostgreSQL database dump complete
--

