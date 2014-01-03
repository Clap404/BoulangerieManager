#!/bin/sh
cat generate.sql populate.sql|sqlite3 BlMgr.sdb
