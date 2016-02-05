--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.0
-- Dumped by pg_dump version 9.5.0

-- Started on 2016-02-05 12:13:51

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 6 (class 2615 OID 32779)
-- Name: auth; Type: SCHEMA; Schema: -; Owner: startup
--

CREATE SCHEMA auth;


ALTER SCHEMA auth OWNER TO startup;

--
-- TOC entry 7 (class 2615 OID 32780)
-- Name: sys; Type: SCHEMA; Schema: -; Owner: startup
--

CREATE SCHEMA sys;


ALTER SCHEMA sys OWNER TO startup;

--
-- TOC entry 210 (class 3079 OID 12355)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2299 (class 0 OID 0)
-- Dependencies: 210
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = auth, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 182 (class 1259 OID 32781)
-- Name: accesstoken; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE accesstoken (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE accesstoken OWNER TO startup;

--
-- TOC entry 183 (class 1259 OID 32784)
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
-- TOC entry 2300 (class 0 OID 0)
-- Dependencies: 183
-- Name: accesstoken_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE accesstoken_id_seq OWNED BY accesstoken.id;


--
-- TOC entry 184 (class 1259 OID 32786)
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
-- TOC entry 185 (class 1259 OID 32789)
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
-- TOC entry 2301 (class 0 OID 0)
-- Dependencies: 185
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


--
-- TOC entry 186 (class 1259 OID 32791)
-- Name: accountscope; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE accountscope (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL,
    scope character varying(64) NOT NULL
);


ALTER TABLE accountscope OWNER TO startup;

--
-- TOC entry 187 (class 1259 OID 32794)
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
-- TOC entry 2302 (class 0 OID 0)
-- Dependencies: 187
-- Name: accountscope_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE accountscope_id_seq OWNED BY accountscope.id;


--
-- TOC entry 188 (class 1259 OID 32796)
-- Name: authzcode; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE authzcode (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE authzcode OWNER TO startup;

--
-- TOC entry 189 (class 1259 OID 32799)
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
-- TOC entry 2303 (class 0 OID 0)
-- Dependencies: 189
-- Name: authzcode_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE authzcode_id_seq OWNED BY authzcode.id;


--
-- TOC entry 209 (class 1259 OID 40971)
-- Name: refreshtoken; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE refreshtoken (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE refreshtoken OWNER TO startup;

--
-- TOC entry 208 (class 1259 OID 40969)
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
-- TOC entry 2304 (class 0 OID 0)
-- Dependencies: 208
-- Name: refreshtoken_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE refreshtoken_id_seq OWNED BY refreshtoken.id;


SET search_path = public, pg_catalog;

--
-- TOC entry 190 (class 1259 OID 32801)
-- Name: account; Type: TABLE; Schema: public; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    code character varying(64) NOT NULL,
    name character varying(256)
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 191 (class 1259 OID 32804)
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
-- TOC entry 2305 (class 0 OID 0)
-- Dependencies: 191
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


SET search_path = sys, pg_catalog;

--
-- TOC entry 192 (class 1259 OID 32806)
-- Name: account; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    id_account bigint NOT NULL
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 193 (class 1259 OID 32809)
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
-- TOC entry 2306 (class 0 OID 0)
-- Dependencies: 193
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


--
-- TOC entry 194 (class 1259 OID 32811)
-- Name: accountrole; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE accountrole (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    role character varying(64) NOT NULL
);


ALTER TABLE accountrole OWNER TO startup;

--
-- TOC entry 195 (class 1259 OID 32814)
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
-- TOC entry 2307 (class 0 OID 0)
-- Dependencies: 195
-- Name: accountrole_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE accountrole_id_seq OWNED BY accountrole.id;


--
-- TOC entry 196 (class 1259 OID 32816)
-- Name: client; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE client (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    secret character varying(128)
);


ALTER TABLE client OWNER TO startup;

--
-- TOC entry 197 (class 1259 OID 32819)
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
-- TOC entry 2308 (class 0 OID 0)
-- Dependencies: 197
-- Name: client_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE client_id_seq OWNED BY client.id;


--
-- TOC entry 198 (class 1259 OID 32821)
-- Name: clientgranttype; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE clientgranttype (
    id bigint NOT NULL,
    id_sys_client bigint NOT NULL,
    granttype character varying(64) NOT NULL
);


ALTER TABLE clientgranttype OWNER TO startup;

--
-- TOC entry 199 (class 1259 OID 32824)
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
-- TOC entry 2309 (class 0 OID 0)
-- Dependencies: 199
-- Name: clientgranttype_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE clientgranttype_id_seq OWNED BY clientgranttype.id;


--
-- TOC entry 200 (class 1259 OID 32826)
-- Name: clientredirecturi; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE clientredirecturi (
    id bigint NOT NULL,
    id_sys_client bigint NOT NULL,
    uri character varying(256) NOT NULL
);


ALTER TABLE clientredirecturi OWNER TO startup;

--
-- TOC entry 201 (class 1259 OID 32829)
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
-- TOC entry 2310 (class 0 OID 0)
-- Dependencies: 201
-- Name: clientredirecturl_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE clientredirecturl_id_seq OWNED BY clientredirecturi.id;


--
-- TOC entry 202 (class 1259 OID 32831)
-- Name: group; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "group" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE "group" OWNER TO startup;

--
-- TOC entry 203 (class 1259 OID 32834)
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
-- TOC entry 2311 (class 0 OID 0)
-- Dependencies: 203
-- Name: group_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE group_id_seq OWNED BY "group".id;


--
-- TOC entry 204 (class 1259 OID 32836)
-- Name: groupaccount; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE groupaccount (
    id bigint NOT NULL,
    id_sys_group bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE groupaccount OWNER TO startup;

--
-- TOC entry 205 (class 1259 OID 32839)
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
-- TOC entry 2312 (class 0 OID 0)
-- Dependencies: 205
-- Name: groupaccount_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE groupaccount_id_seq OWNED BY groupaccount.id;


--
-- TOC entry 206 (class 1259 OID 32841)
-- Name: user; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "user" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    password character varying(128)
);


ALTER TABLE "user" OWNER TO startup;

--
-- TOC entry 207 (class 1259 OID 32844)
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
-- TOC entry 2313 (class 0 OID 0)
-- Dependencies: 207
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


SET search_path = auth, pg_catalog;

--
-- TOC entry 2061 (class 2604 OID 32846)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken ALTER COLUMN id SET DEFAULT nextval('accesstoken_id_seq'::regclass);


--
-- TOC entry 2062 (class 2604 OID 32847)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- TOC entry 2063 (class 2604 OID 32848)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope ALTER COLUMN id SET DEFAULT nextval('accountscope_id_seq'::regclass);


--
-- TOC entry 2064 (class 2604 OID 32849)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode ALTER COLUMN id SET DEFAULT nextval('authzcode_id_seq'::regclass);


--
-- TOC entry 2074 (class 2604 OID 40974)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken ALTER COLUMN id SET DEFAULT nextval('refreshtoken_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 2065 (class 2604 OID 32850)
-- Name: id; Type: DEFAULT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2066 (class 2604 OID 32851)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- TOC entry 2067 (class 2604 OID 32852)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole ALTER COLUMN id SET DEFAULT nextval('accountrole_id_seq'::regclass);


--
-- TOC entry 2068 (class 2604 OID 32853)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client ALTER COLUMN id SET DEFAULT nextval('client_id_seq'::regclass);


--
-- TOC entry 2069 (class 2604 OID 32854)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype ALTER COLUMN id SET DEFAULT nextval('clientgranttype_id_seq'::regclass);


--
-- TOC entry 2070 (class 2604 OID 32855)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi ALTER COLUMN id SET DEFAULT nextval('clientredirecturl_id_seq'::regclass);


--
-- TOC entry 2071 (class 2604 OID 32856)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group" ALTER COLUMN id SET DEFAULT nextval('group_id_seq'::regclass);


--
-- TOC entry 2072 (class 2604 OID 32857)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount ALTER COLUMN id SET DEFAULT nextval('groupaccount_id_seq'::regclass);


--
-- TOC entry 2073 (class 2604 OID 32858)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2264 (class 0 OID 32781)
-- Dependencies: 182
-- Data for Name: accesstoken; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY accesstoken (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2314 (class 0 OID 0)
-- Dependencies: 183
-- Name: accesstoken_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('accesstoken_id_seq', 1, false);


--
-- TOC entry 2266 (class 0 OID 32786)
-- Dependencies: 184
-- Data for Name: account; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY account (id, code, client_id, user_id, expires) FROM stdin;
\.


--
-- TOC entry 2315 (class 0 OID 0)
-- Dependencies: 185
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- TOC entry 2268 (class 0 OID 32791)
-- Dependencies: 186
-- Data for Name: accountscope; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY accountscope (id, id_auth_account, scope) FROM stdin;
\.


--
-- TOC entry 2316 (class 0 OID 0)
-- Dependencies: 187
-- Name: accountscope_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('accountscope_id_seq', 1, false);


--
-- TOC entry 2270 (class 0 OID 32796)
-- Dependencies: 188
-- Data for Name: authzcode; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY authzcode (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2317 (class 0 OID 0)
-- Dependencies: 189
-- Name: authzcode_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('authzcode_id_seq', 1, false);


--
-- TOC entry 2291 (class 0 OID 40971)
-- Dependencies: 209
-- Data for Name: refreshtoken; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY refreshtoken (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2318 (class 0 OID 0)
-- Dependencies: 208
-- Name: refreshtoken_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('refreshtoken_id_seq', 1, false);


SET search_path = public, pg_catalog;

--
-- TOC entry 2272 (class 0 OID 32801)
-- Dependencies: 190
-- Data for Name: account; Type: TABLE DATA; Schema: public; Owner: startup
--

COPY account (id, code, name) FROM stdin;
\.


--
-- TOC entry 2319 (class 0 OID 0)
-- Dependencies: 191
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: public; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2274 (class 0 OID 32806)
-- Dependencies: 192
-- Data for Name: account; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY account (id, id_account) FROM stdin;
\.


--
-- TOC entry 2320 (class 0 OID 0)
-- Dependencies: 193
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- TOC entry 2276 (class 0 OID 32811)
-- Dependencies: 194
-- Data for Name: accountrole; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY accountrole (id, id_sys_account, role) FROM stdin;
\.


--
-- TOC entry 2321 (class 0 OID 0)
-- Dependencies: 195
-- Name: accountrole_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('accountrole_id_seq', 1, false);


--
-- TOC entry 2278 (class 0 OID 32816)
-- Dependencies: 196
-- Data for Name: client; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY client (id, id_sys_account, secret) FROM stdin;
\.


--
-- TOC entry 2322 (class 0 OID 0)
-- Dependencies: 197
-- Name: client_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('client_id_seq', 1, false);


--
-- TOC entry 2280 (class 0 OID 32821)
-- Dependencies: 198
-- Data for Name: clientgranttype; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY clientgranttype (id, id_sys_client, granttype) FROM stdin;
\.


--
-- TOC entry 2323 (class 0 OID 0)
-- Dependencies: 199
-- Name: clientgranttype_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('clientgranttype_id_seq', 1, false);


--
-- TOC entry 2282 (class 0 OID 32826)
-- Dependencies: 200
-- Data for Name: clientredirecturi; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY clientredirecturi (id, id_sys_client, uri) FROM stdin;
\.


--
-- TOC entry 2324 (class 0 OID 0)
-- Dependencies: 201
-- Name: clientredirecturl_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('clientredirecturl_id_seq', 1, false);


--
-- TOC entry 2284 (class 0 OID 32831)
-- Dependencies: 202
-- Data for Name: group; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "group" (id, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2325 (class 0 OID 0)
-- Dependencies: 203
-- Name: group_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('group_id_seq', 1, false);


--
-- TOC entry 2286 (class 0 OID 32836)
-- Dependencies: 204
-- Data for Name: groupaccount; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY groupaccount (id, id_sys_group, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2326 (class 0 OID 0)
-- Dependencies: 205
-- Name: groupaccount_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('groupaccount_id_seq', 1, false);


--
-- TOC entry 2288 (class 0 OID 32841)
-- Dependencies: 206
-- Data for Name: user; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "user" (id, id_sys_account, password) FROM stdin;
\.


--
-- TOC entry 2327 (class 0 OID 0)
-- Dependencies: 207
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('user_id_seq', 1, false);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2076 (class 2606 OID 32860)
-- Name: accesstoken_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2078 (class 2606 OID 32862)
-- Name: accesstoken_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_pkey PRIMARY KEY (id);


--
-- TOC entry 2081 (class 2606 OID 32864)
-- Name: account_code_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_code_key UNIQUE (code);


--
-- TOC entry 2084 (class 2606 OID 32866)
-- Name: account_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- TOC entry 2087 (class 2606 OID 32868)
-- Name: accountscope_id_auth_account_scope_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_id_auth_account_scope_key UNIQUE (id_auth_account, scope);


--
-- TOC entry 2089 (class 2606 OID 32870)
-- Name: accountscope_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_pkey PRIMARY KEY (id);


--
-- TOC entry 2091 (class 2606 OID 32872)
-- Name: authzcode_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2093 (class 2606 OID 32874)
-- Name: authzcode_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_pkey PRIMARY KEY (id);


--
-- TOC entry 2134 (class 2606 OID 40978)
-- Name: refreshtoken_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken
    ADD CONSTRAINT refreshtoken_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2136 (class 2606 OID 40976)
-- Name: refreshtoken_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken
    ADD CONSTRAINT refreshtoken_pkey PRIMARY KEY (id);


SET search_path = public, pg_catalog;

--
-- TOC entry 2095 (class 2606 OID 32876)
-- Name: account_code_key; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_code_key UNIQUE (code);


--
-- TOC entry 2097 (class 2606 OID 32878)
-- Name: account_pkey; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2099 (class 2606 OID 32880)
-- Name: account_id_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_key UNIQUE (id_account);


--
-- TOC entry 2101 (class 2606 OID 32882)
-- Name: account_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- TOC entry 2103 (class 2606 OID 32884)
-- Name: accountrole_id_sys_account_role_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_role_key UNIQUE (id_sys_account, role);


--
-- TOC entry 2105 (class 2606 OID 32886)
-- Name: accountrole_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_pkey PRIMARY KEY (id);


--
-- TOC entry 2108 (class 2606 OID 32888)
-- Name: client_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2110 (class 2606 OID 32890)
-- Name: client_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id);


--
-- TOC entry 2113 (class 2606 OID 32892)
-- Name: clientgranttype_id_sys_client_granttype_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_id_sys_client_granttype_key UNIQUE (id_sys_client, granttype);


--
-- TOC entry 2115 (class 2606 OID 32894)
-- Name: clientgranttype_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_pkey PRIMARY KEY (id);


--
-- TOC entry 2117 (class 2606 OID 32979)
-- Name: clientredirecturi_id_sys_client_uri_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi
    ADD CONSTRAINT clientredirecturi_id_sys_client_uri_key UNIQUE (id_sys_client, uri);


--
-- TOC entry 2119 (class 2606 OID 32898)
-- Name: clientredirecturl_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi
    ADD CONSTRAINT clientredirecturl_pkey PRIMARY KEY (id);


--
-- TOC entry 2121 (class 2606 OID 32900)
-- Name: group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2123 (class 2606 OID 32902)
-- Name: group_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_pkey PRIMARY KEY (id);


--
-- TOC entry 2126 (class 2606 OID 32904)
-- Name: groupaccount_id_sys_group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_id_sys_account_key UNIQUE (id_sys_group, id_sys_account);


--
-- TOC entry 2128 (class 2606 OID 32906)
-- Name: groupaccount_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_pkey PRIMARY KEY (id);


--
-- TOC entry 2130 (class 2606 OID 32908)
-- Name: user_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2132 (class 2606 OID 32910)
-- Name: user_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2079 (class 1259 OID 32911)
-- Name: account_client_id_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_client_id_idx ON account USING btree (client_id);


--
-- TOC entry 2082 (class 1259 OID 32912)
-- Name: account_expires_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_expires_idx ON account USING btree (expires);


--
-- TOC entry 2085 (class 1259 OID 32913)
-- Name: account_user_id_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_user_id_idx ON account USING btree (user_id);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2106 (class 1259 OID 32914)
-- Name: accountrole_role_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX accountrole_role_idx ON accountrole USING btree (role);


--
-- TOC entry 2111 (class 1259 OID 32915)
-- Name: clientgranttype_granttype_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX clientgranttype_granttype_idx ON clientgranttype USING btree (granttype);


--
-- TOC entry 2124 (class 1259 OID 32916)
-- Name: groupaccount_id_sys_account_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX groupaccount_id_sys_account_idx ON groupaccount USING btree (id_sys_account);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2137 (class 2606 OID 32917)
-- Name: accesstoken_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2138 (class 2606 OID 32922)
-- Name: accountscope_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2139 (class 2606 OID 32927)
-- Name: authzcode_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2149 (class 2606 OID 40979)
-- Name: refreshtoken_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY refreshtoken
    ADD CONSTRAINT refreshtoken_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


SET search_path = sys, pg_catalog;

--
-- TOC entry 2140 (class 2606 OID 32932)
-- Name: account_id_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_fkey FOREIGN KEY (id_account) REFERENCES public.account(id) ON DELETE CASCADE;


--
-- TOC entry 2141 (class 2606 OID 32937)
-- Name: accountrole_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2142 (class 2606 OID 32942)
-- Name: client_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2143 (class 2606 OID 32947)
-- Name: clientgranttype_id_sys_client_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_id_sys_client_fkey FOREIGN KEY (id_sys_client) REFERENCES client(id_sys_account) ON DELETE CASCADE;


--
-- TOC entry 2144 (class 2606 OID 32952)
-- Name: clientredirecturl_id_sys_client_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturi
    ADD CONSTRAINT clientredirecturl_id_sys_client_fkey FOREIGN KEY (id_sys_client) REFERENCES client(id_sys_account) ON DELETE CASCADE;


--
-- TOC entry 2145 (class 2606 OID 32957)
-- Name: group_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2146 (class 2606 OID 32962)
-- Name: groupaccount_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2147 (class 2606 OID 32967)
-- Name: groupaccount_id_sys_group_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_fkey FOREIGN KEY (id_sys_group) REFERENCES "group"(id) ON DELETE CASCADE;


--
-- TOC entry 2148 (class 2606 OID 32972)
-- Name: user_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2298 (class 0 OID 0)
-- Dependencies: 8
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-02-05 12:13:52

--
-- PostgreSQL database dump complete
--

