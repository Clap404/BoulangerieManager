#!/usr/bin/sh
cat GenerateTables.sql TestValues.sql|sqlite3 BlMgr.sdb
