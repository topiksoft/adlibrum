curl ftp://ftp.gondolatiro.hu/domains/adlibrum.hu/public_html/books/books.db --user gondolat:Hintav77 > books.db
sqlite3 books.db .schema > books_schema.sql
sqlite3 books.db .dump > books_dump.sql
grep -vx -f books_schema.sql books_dump.sql > books_data.sql
