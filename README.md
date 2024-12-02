<<<<<<< HEAD
1- Testes unitários com Pest
2- Transações em Aplicações Laravel ( DB::beginTransaction(), DB::commit() e DB::rollback())
3- Autenticação e Autorização
4- API de aplicação
5- Proteção e Codificação
=======
Autor: delfinna
>>>>>>> 46898c1fcb2d1d261b6946dbdbe7c3867ea602cd

# Comando pra executar o projeto
php artisan serve

# Comando pra iniciar servidor node pra API Gemini
node server.js

# Comandos pra fazer Testes Unitários

# Pra fazer todos os testes ao mesmo tempo
php artisan test

# Testar o acesso não autorizado de usários a tabela de paciente
php artisan test --filter=PacienteAccessTest

#Testar o registro de logs
php artisan test --filter=PacienteLogTest






#**************************************************************************************************#
2. Transações em Aplicações Laravel
Descrição
Para assegurar a consistência dos dados durante operações críticas, foram utilizadas transações do Laravel através dos métodos DB::beginTransaction(), DB::commit() e DB::rollback().

Implementação:
Operações Transacionais:
Criação de pacientes com validação e registro de logs em uma única transação.
Caso ocorra um erro durante a operação, a transação é revertida usando DB::rollback().
Ferramentas Necessárias:
Banco de Dados Relacional configurado no Laravel (MySQL ou outro).
Pacotes nativos do Laravel para gerenciamento de transações.




#***************************************************************************************************#