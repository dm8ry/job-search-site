/*
 delete user MySQL
*/

delete from businesslog where upper(email) = upper('quadro13@yandex.ru');
delete from user_positions where user_id = (select id from users where upper(email) = upper('quadro13@yandex.ru'));
delete from smart_agent where user_id = (select id from users where upper(email) = upper('quadro13@yandex.ru'));
delete from resumes where user_id = (select id from users where upper(email) = upper('quadro13@yandex.ru'));
delete from users where upper(email) = upper('quadro13@yandex.ru');