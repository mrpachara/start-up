--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.0
-- Dumped by pg_dump version 9.5.0

-- Started on 2016-02-04 15:57:18 ICT

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 8 (class 2615 OID 17196)
-- Name: auth; Type: SCHEMA; Schema: -; Owner: startup
--

CREATE SCHEMA auth;


ALTER SCHEMA auth OWNER TO startup;

--
-- TOC entry 7 (class 2615 OID 17035)
-- Name: sys; Type: SCHEMA; Schema: -; Owner: startup
--

CREATE SCHEMA sys;


ALTER SCHEMA sys OWNER TO startup;

--
-- TOC entry 208 (class 3079 OID 12395)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2323 (class 0 OID 0)
-- Dependencies: 208
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = auth, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 203 (class 1259 OID 17243)
-- Name: accesstoken; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE accesstoken (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE accesstoken OWNER TO startup;

--
-- TOC entry 202 (class 1259 OID 17241)
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
-- TOC entry 2324 (class 0 OID 0)
-- Dependencies: 202
-- Name: accesstoken_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE accesstoken_id_seq OWNED BY accesstoken.id;


--
-- TOC entry 201 (class 1259 OID 17230)
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
-- TOC entry 200 (class 1259 OID 17228)
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
-- TOC entry 2325 (class 0 OID 0)
-- Dependencies: 200
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


--
-- TOC entry 205 (class 1259 OID 17258)
-- Name: accountscope; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE accountscope (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL,
    scope character varying(64) NOT NULL
);


ALTER TABLE accountscope OWNER TO startup;

--
-- TOC entry 204 (class 1259 OID 17256)
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
-- TOC entry 2326 (class 0 OID 0)
-- Dependencies: 204
-- Name: accountscope_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE accountscope_id_seq OWNED BY accountscope.id;


--
-- TOC entry 207 (class 1259 OID 17273)
-- Name: authzcode; Type: TABLE; Schema: auth; Owner: startup
--

CREATE TABLE authzcode (
    id bigint NOT NULL,
    id_auth_account bigint NOT NULL
);


ALTER TABLE authzcode OWNER TO startup;

--
-- TOC entry 206 (class 1259 OID 17271)
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
-- TOC entry 2327 (class 0 OID 0)
-- Dependencies: 206
-- Name: authzcode_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: startup
--

ALTER SEQUENCE authzcode_id_seq OWNED BY authzcode.id;


SET search_path = public, pg_catalog;

--
-- TOC entry 183 (class 1259 OID 17027)
-- Name: account; Type: TABLE; Schema: public; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    code character varying(64) NOT NULL,
    name character varying(256)
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 182 (class 1259 OID 17025)
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
-- TOC entry 2328 (class 0 OID 0)
-- Dependencies: 182
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


SET search_path = sys, pg_catalog;

--
-- TOC entry 185 (class 1259 OID 17038)
-- Name: account; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE account (
    id bigint NOT NULL,
    id_account bigint NOT NULL
);


ALTER TABLE account OWNER TO startup;

--
-- TOC entry 184 (class 1259 OID 17036)
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
-- TOC entry 2329 (class 0 OID 0)
-- Dependencies: 184
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE account_id_seq OWNED BY account.id;


--
-- TOC entry 194 (class 1259 OID 17131)
-- Name: accountrole; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE accountrole (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    role character varying(64) NOT NULL
);


ALTER TABLE accountrole OWNER TO startup;

--
-- TOC entry 193 (class 1259 OID 17129)
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
-- TOC entry 2330 (class 0 OID 0)
-- Dependencies: 193
-- Name: accountrole_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE accountrole_id_seq OWNED BY accountrole.id;


--
-- TOC entry 190 (class 1259 OID 17088)
-- Name: client; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE client (
    id_sys_account bigint NOT NULL,
    secret character varying(128),
    id bigint NOT NULL
);


ALTER TABLE client OWNER TO startup;

--
-- TOC entry 195 (class 1259 OID 17155)
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
-- TOC entry 2331 (class 0 OID 0)
-- Dependencies: 195
-- Name: client_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE client_id_seq OWNED BY client.id;


--
-- TOC entry 197 (class 1259 OID 17166)
-- Name: clientgranttype; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE clientgranttype (
    id bigint NOT NULL,
    id_sys_client bigint NOT NULL,
    granttype character varying(64) NOT NULL
);


ALTER TABLE clientgranttype OWNER TO startup;

--
-- TOC entry 196 (class 1259 OID 17164)
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
-- TOC entry 2332 (class 0 OID 0)
-- Dependencies: 196
-- Name: clientgranttype_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE clientgranttype_id_seq OWNED BY clientgranttype.id;


--
-- TOC entry 199 (class 1259 OID 17182)
-- Name: clientredirecturl; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE clientredirecturl (
    id bigint NOT NULL,
    id_sys_client bigint NOT NULL,
    url character varying(256) NOT NULL
);


ALTER TABLE clientredirecturl OWNER TO startup;

--
-- TOC entry 198 (class 1259 OID 17180)
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
-- TOC entry 2333 (class 0 OID 0)
-- Dependencies: 198
-- Name: clientredirecturl_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE clientredirecturl_id_seq OWNED BY clientredirecturl.id;


--
-- TOC entry 189 (class 1259 OID 17075)
-- Name: group; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "group" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE "group" OWNER TO startup;

--
-- TOC entry 188 (class 1259 OID 17073)
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
-- TOC entry 2334 (class 0 OID 0)
-- Dependencies: 188
-- Name: group_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE group_id_seq OWNED BY "group".id;


--
-- TOC entry 192 (class 1259 OID 17110)
-- Name: groupaccount; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE groupaccount (
    id bigint NOT NULL,
    id_sys_group bigint NOT NULL,
    id_sys_account bigint NOT NULL
);


ALTER TABLE groupaccount OWNER TO startup;

--
-- TOC entry 191 (class 1259 OID 17108)
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
-- TOC entry 2335 (class 0 OID 0)
-- Dependencies: 191
-- Name: groupaccount_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE groupaccount_id_seq OWNED BY groupaccount.id;


--
-- TOC entry 187 (class 1259 OID 17053)
-- Name: user; Type: TABLE; Schema: sys; Owner: startup
--

CREATE TABLE "user" (
    id bigint NOT NULL,
    id_sys_account bigint NOT NULL,
    password character varying(128)
);


ALTER TABLE "user" OWNER TO startup;

--
-- TOC entry 186 (class 1259 OID 17051)
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
-- TOC entry 2336 (class 0 OID 0)
-- Dependencies: 186
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: sys; Owner: startup
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


SET search_path = auth, pg_catalog;

--
-- TOC entry 2103 (class 2604 OID 17246)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken ALTER COLUMN id SET DEFAULT nextval('accesstoken_id_seq'::regclass);


--
-- TOC entry 2102 (class 2604 OID 17233)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- TOC entry 2104 (class 2604 OID 17261)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope ALTER COLUMN id SET DEFAULT nextval('accountscope_id_seq'::regclass);


--
-- TOC entry 2105 (class 2604 OID 17276)
-- Name: id; Type: DEFAULT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode ALTER COLUMN id SET DEFAULT nextval('authzcode_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 2093 (class 2604 OID 17030)
-- Name: id; Type: DEFAULT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2094 (class 2604 OID 17041)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- TOC entry 2099 (class 2604 OID 17134)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole ALTER COLUMN id SET DEFAULT nextval('accountrole_id_seq'::regclass);


--
-- TOC entry 2097 (class 2604 OID 17157)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client ALTER COLUMN id SET DEFAULT nextval('client_id_seq'::regclass);


--
-- TOC entry 2100 (class 2604 OID 17169)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype ALTER COLUMN id SET DEFAULT nextval('clientgranttype_id_seq'::regclass);


--
-- TOC entry 2101 (class 2604 OID 17185)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturl ALTER COLUMN id SET DEFAULT nextval('clientredirecturl_id_seq'::regclass);


--
-- TOC entry 2096 (class 2604 OID 17078)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group" ALTER COLUMN id SET DEFAULT nextval('group_id_seq'::regclass);


--
-- TOC entry 2098 (class 2604 OID 17113)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount ALTER COLUMN id SET DEFAULT nextval('groupaccount_id_seq'::regclass);


--
-- TOC entry 2095 (class 2604 OID 17056)
-- Name: id; Type: DEFAULT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2311 (class 0 OID 17243)
-- Dependencies: 203
-- Data for Name: accesstoken; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY accesstoken (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2337 (class 0 OID 0)
-- Dependencies: 202
-- Name: accesstoken_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('accesstoken_id_seq', 1, false);


--
-- TOC entry 2309 (class 0 OID 17230)
-- Dependencies: 201
-- Data for Name: account; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY account (id, code, client_id, user_id, expires) FROM stdin;
\.


--
-- TOC entry 2338 (class 0 OID 0)
-- Dependencies: 200
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- TOC entry 2313 (class 0 OID 17258)
-- Dependencies: 205
-- Data for Name: accountscope; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY accountscope (id, id_auth_account, scope) FROM stdin;
\.


--
-- TOC entry 2339 (class 0 OID 0)
-- Dependencies: 204
-- Name: accountscope_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('accountscope_id_seq', 1, false);


--
-- TOC entry 2315 (class 0 OID 17273)
-- Dependencies: 207
-- Data for Name: authzcode; Type: TABLE DATA; Schema: auth; Owner: startup
--

COPY authzcode (id, id_auth_account) FROM stdin;
\.


--
-- TOC entry 2340 (class 0 OID 0)
-- Dependencies: 206
-- Name: authzcode_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: startup
--

SELECT pg_catalog.setval('authzcode_id_seq', 1, false);


SET search_path = public, pg_catalog;

--
-- TOC entry 2291 (class 0 OID 17027)
-- Dependencies: 183
-- Data for Name: account; Type: TABLE DATA; Schema: public; Owner: startup
--

COPY account (id, code, name) FROM stdin;
\.


--
-- TOC entry 2341 (class 0 OID 0)
-- Dependencies: 182
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: public; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2293 (class 0 OID 17038)
-- Dependencies: 185
-- Data for Name: account; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY account (id, id_account) FROM stdin;
\.


--
-- TOC entry 2342 (class 0 OID 0)
-- Dependencies: 184
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- TOC entry 2302 (class 0 OID 17131)
-- Dependencies: 194
-- Data for Name: accountrole; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY accountrole (id, id_sys_account, role) FROM stdin;
\.


--
-- TOC entry 2343 (class 0 OID 0)
-- Dependencies: 193
-- Name: accountrole_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('accountrole_id_seq', 1, false);


--
-- TOC entry 2298 (class 0 OID 17088)
-- Dependencies: 190
-- Data for Name: client; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY client (id_sys_account, secret, id) FROM stdin;
\.


--
-- TOC entry 2344 (class 0 OID 0)
-- Dependencies: 195
-- Name: client_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('client_id_seq', 1, false);


--
-- TOC entry 2305 (class 0 OID 17166)
-- Dependencies: 197
-- Data for Name: clientgranttype; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY clientgranttype (id, id_sys_client, granttype) FROM stdin;
\.


--
-- TOC entry 2345 (class 0 OID 0)
-- Dependencies: 196
-- Name: clientgranttype_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('clientgranttype_id_seq', 1, false);


--
-- TOC entry 2307 (class 0 OID 17182)
-- Dependencies: 199
-- Data for Name: clientredirecturl; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY clientredirecturl (id, id_sys_client, url) FROM stdin;
\.


--
-- TOC entry 2346 (class 0 OID 0)
-- Dependencies: 198
-- Name: clientredirecturl_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('clientredirecturl_id_seq', 1, false);


--
-- TOC entry 2297 (class 0 OID 17075)
-- Dependencies: 189
-- Data for Name: group; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "group" (id, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2347 (class 0 OID 0)
-- Dependencies: 188
-- Name: group_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('group_id_seq', 1, false);


--
-- TOC entry 2300 (class 0 OID 17110)
-- Dependencies: 192
-- Data for Name: groupaccount; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY groupaccount (id, id_sys_group, id_sys_account) FROM stdin;
\.


--
-- TOC entry 2348 (class 0 OID 0)
-- Dependencies: 191
-- Name: groupaccount_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('groupaccount_id_seq', 1, false);


--
-- TOC entry 2295 (class 0 OID 17053)
-- Dependencies: 187
-- Data for Name: user; Type: TABLE DATA; Schema: sys; Owner: startup
--

COPY "user" (id, id_sys_account, password) FROM stdin;
\.


--
-- TOC entry 2349 (class 0 OID 0)
-- Dependencies: 186
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: sys; Owner: startup
--

SELECT pg_catalog.setval('user_id_seq', 1, false);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2153 (class 2606 OID 17250)
-- Name: accesstoken_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2155 (class 2606 OID 17248)
-- Name: accesstoken_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_pkey PRIMARY KEY (id);


--
-- TOC entry 2147 (class 2606 OID 17237)
-- Name: account_code_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_code_key UNIQUE (code);


--
-- TOC entry 2150 (class 2606 OID 17235)
-- Name: account_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- TOC entry 2157 (class 2606 OID 17265)
-- Name: accountscope_id_auth_account_scope_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_id_auth_account_scope_key UNIQUE (id_auth_account, scope);


--
-- TOC entry 2159 (class 2606 OID 17263)
-- Name: accountscope_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_pkey PRIMARY KEY (id);


--
-- TOC entry 2161 (class 2606 OID 17280)
-- Name: authzcode_id_auth_account_key; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_id_auth_account_key UNIQUE (id_auth_account);


--
-- TOC entry 2163 (class 2606 OID 17278)
-- Name: authzcode_pkey; Type: CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_pkey PRIMARY KEY (id);


SET search_path = public, pg_catalog;

--
-- TOC entry 2107 (class 2606 OID 17034)
-- Name: account_code_key; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_code_key UNIQUE (code);


--
-- TOC entry 2109 (class 2606 OID 17032)
-- Name: account_pkey; Type: CONSTRAINT; Schema: public; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2111 (class 2606 OID 17067)
-- Name: account_id_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_key UNIQUE (id_account);


--
-- TOC entry 2113 (class 2606 OID 17043)
-- Name: account_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- TOC entry 2132 (class 2606 OID 17138)
-- Name: accountrole_id_sys_account_role_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_role_key UNIQUE (id_sys_account, role);


--
-- TOC entry 2134 (class 2606 OID 17136)
-- Name: accountrole_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_pkey PRIMARY KEY (id);


--
-- TOC entry 2123 (class 2606 OID 17097)
-- Name: client_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2125 (class 2606 OID 17163)
-- Name: client_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id);


--
-- TOC entry 2138 (class 2606 OID 17173)
-- Name: clientgranttype_id_sys_client_granttype_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_id_sys_client_granttype_key UNIQUE (id_sys_client, granttype);


--
-- TOC entry 2140 (class 2606 OID 17171)
-- Name: clientgranttype_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_pkey PRIMARY KEY (id);


--
-- TOC entry 2142 (class 2606 OID 17189)
-- Name: clientredirecturl_id_sys_client_url_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturl
    ADD CONSTRAINT clientredirecturl_id_sys_client_url_key UNIQUE (id_sys_client, url);


--
-- TOC entry 2144 (class 2606 OID 17187)
-- Name: clientredirecturl_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturl
    ADD CONSTRAINT clientredirecturl_pkey PRIMARY KEY (id);


--
-- TOC entry 2119 (class 2606 OID 17082)
-- Name: group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2121 (class 2606 OID 17080)
-- Name: group_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_pkey PRIMARY KEY (id);


--
-- TOC entry 2128 (class 2606 OID 17117)
-- Name: groupaccount_id_sys_group_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_id_sys_account_key UNIQUE (id_sys_group, id_sys_account);


--
-- TOC entry 2130 (class 2606 OID 17115)
-- Name: groupaccount_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_pkey PRIMARY KEY (id);


--
-- TOC entry 2115 (class 2606 OID 17060)
-- Name: user_id_sys_account_key; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_key UNIQUE (id_sys_account);


--
-- TOC entry 2117 (class 2606 OID 17058)
-- Name: user_pkey; Type: CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2145 (class 1259 OID 17238)
-- Name: account_client_id_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_client_id_idx ON account USING btree (client_id);


--
-- TOC entry 2148 (class 1259 OID 17240)
-- Name: account_expires_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_expires_idx ON account USING btree (expires);


--
-- TOC entry 2151 (class 1259 OID 17239)
-- Name: account_user_id_idx; Type: INDEX; Schema: auth; Owner: startup
--

CREATE INDEX account_user_id_idx ON account USING btree (user_id);


SET search_path = sys, pg_catalog;

--
-- TOC entry 2135 (class 1259 OID 17144)
-- Name: accountrole_role_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX accountrole_role_idx ON accountrole USING btree (role);


--
-- TOC entry 2136 (class 1259 OID 17179)
-- Name: clientgranttype_granttype_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX clientgranttype_granttype_idx ON clientgranttype USING btree (granttype);


--
-- TOC entry 2126 (class 1259 OID 17128)
-- Name: groupaccount_id_sys_account_idx; Type: INDEX; Schema: sys; Owner: startup
--

CREATE INDEX groupaccount_id_sys_account_idx ON groupaccount USING btree (id_sys_account);


SET search_path = auth, pg_catalog;

--
-- TOC entry 2173 (class 2606 OID 17251)
-- Name: accesstoken_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accesstoken
    ADD CONSTRAINT accesstoken_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2174 (class 2606 OID 17266)
-- Name: accountscope_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY accountscope
    ADD CONSTRAINT accountscope_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2175 (class 2606 OID 17281)
-- Name: authzcode_id_auth_account_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: startup
--

ALTER TABLE ONLY authzcode
    ADD CONSTRAINT authzcode_id_auth_account_fkey FOREIGN KEY (id_auth_account) REFERENCES account(id) ON DELETE CASCADE;


SET search_path = sys, pg_catalog;

--
-- TOC entry 2164 (class 2606 OID 17068)
-- Name: account_id_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY account
    ADD CONSTRAINT account_id_account_fkey FOREIGN KEY (id_account) REFERENCES public.account(id) ON DELETE CASCADE;


--
-- TOC entry 2170 (class 2606 OID 17139)
-- Name: accountrole_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY accountrole
    ADD CONSTRAINT accountrole_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2167 (class 2606 OID 17098)
-- Name: client_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY client
    ADD CONSTRAINT client_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2171 (class 2606 OID 17174)
-- Name: clientgranttype_id_sys_client_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientgranttype
    ADD CONSTRAINT clientgranttype_id_sys_client_fkey FOREIGN KEY (id_sys_client) REFERENCES client(id_sys_account) ON DELETE CASCADE;


--
-- TOC entry 2172 (class 2606 OID 17190)
-- Name: clientredirecturl_id_sys_client_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY clientredirecturl
    ADD CONSTRAINT clientredirecturl_id_sys_client_fkey FOREIGN KEY (id_sys_client) REFERENCES client(id_sys_account) ON DELETE CASCADE;


--
-- TOC entry 2166 (class 2606 OID 17103)
-- Name: group_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2169 (class 2606 OID 17123)
-- Name: groupaccount_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2168 (class 2606 OID 17118)
-- Name: groupaccount_id_sys_group_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY groupaccount
    ADD CONSTRAINT groupaccount_id_sys_group_fkey FOREIGN KEY (id_sys_group) REFERENCES "group"(id) ON DELETE CASCADE;


--
-- TOC entry 2165 (class 2606 OID 17061)
-- Name: user_id_sys_account_fkey; Type: FK CONSTRAINT; Schema: sys; Owner: startup
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id_sys_account_fkey FOREIGN KEY (id_sys_account) REFERENCES account(id) ON DELETE CASCADE;


--
-- TOC entry 2322 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-02-04 15:57:19 ICT

--
-- PostgreSQL database dump complete
--

