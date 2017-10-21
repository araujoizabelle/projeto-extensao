/*
Alterações feitas para extinguir os eventos parte 1 e parte 2
 => os horários passam a pertencer a um único evento
*/
update tb_horarioEvento set evento_id=8 where id=19

update tb_horarioEvento set evento_id=19 where id=24

update tb_horarioEvento set evento_id=4 where id=9

update tb_horarioEvento set evento_id=5 where id=21

update tb_horarioEvento set evento_id=34 where id=44


update tb_evento set nome="Curso Básico de Arduíno" WHERE id=8;

update tb_evento set nome="Modelagem de Processos de Negócio Utilizando o Bizagi" where id=4;

update tb_evento set nome="Gestão de Projetos com o MS-PROJECT" where id=19


update tb_evento set nome="Oratória: Comunicação e Técnicas de Apresentação de Trabalhos Acadêmicos" where id=5

update tb_evento set nome="Montagem e Configuração de um Quadricóptero aplicado na Pesquisa de Veículos Autônomos" where id=34

/*
insert into tb_inscricao (usuario_id, evento_id) values 
(11, 9), (12, 9), (19, 9), (22, 9), (24, 9), (29, 9), (65, 9), (67, 9)
*/