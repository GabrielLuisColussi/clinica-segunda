# 🔧 Guia - Conectar Docker ao MySQL do XAMPP

## ⚠️ Erro: Connection refused

O container não está conseguindo conectar ao MySQL do XAMPP. Siga estes passos:

---

## ✅ PASSO 1: Verificar o `.env`

Abra o arquivo `.env` na raiz do projeto e verifique se está assim:

```env
DB_CONNECTION=mysql
DB_HOST=host.docker.internal
DB_PORT=3306
DB_DATABASE=clinica
DB_USERNAME=root
DB_PASSWORD=
```

**Importante:**
- `DB_HOST=host.docker.internal` ← **Deve ser exatamente isso!**
- `DB_DATABASE` → Nome do seu banco no MySQL
- `DB_USERNAME` → Normalmente `root` no XAMPP
- `DB_PASSWORD` → Deixe vazio se não tiver senha, ou coloque a senha

---

## ✅ PASSO 2: Verificar se o MySQL do XAMPP está rodando

1. Abra o **XAMPP Control Panel**
2. Verifique se o **MySQL** está com status **"Running"** (verde)
3. Se não estiver, clique em **Start**

---

## ✅ PASSO 3: Configurar o MySQL para aceitar conexões externas

O MySQL do XAMPP por padrão só aceita conexões de `localhost`. Precisamos permitir conexões do Docker.

### Opção A: Via phpMyAdmin (Mais fácil)

1. Abra o **XAMPP Control Panel**
2. Clique em **Admin** ao lado do MySQL (abre phpMyAdmin)
3. Vá na aba **SQL**
4. Execute este comando (substitua `clinica` pelo nome do seu banco):

```sql
-- Criar usuário que aceita conexões de qualquer host
CREATE USER IF NOT EXISTS 'clinica'@'%' IDENTIFIED BY 'senha123';
GRANT ALL PRIVILEGES ON clinica.* TO 'clinica'@'%';
FLUSH PRIVILEGES;
```

5. Atualize o `.env`:
```env
DB_USERNAME=clinica
DB_PASSWORD=senha123
```

### Opção B: Editar my.ini (Alternativa)

1. No **XAMPP Control Panel**, clique em **Config** ao lado do MySQL
2. Escolha **my.ini**
3. Procure por `bind-address = 127.0.0.1`
4. Comente ou altere para:
   ```
   bind-address = 0.0.0.0
   ```
5. Salve e **reinicie o MySQL** no XAMPP

---

## ✅ PASSO 4: Reiniciar os containers

No Docker Desktop:

1. **Pare** o stack `clinica` (botão Stop)
2. **Inicie** novamente (botão Start)

Ou via terminal:
```bash
docker compose down
docker compose up -d
```

---

## ✅ PASSO 5: Testar a conexão

No terminal do container `clinica_app`:

```bash
php artisan migrate
```

Se funcionar, você verá as migrations sendo executadas! ✅

---

## 🔍 Verificar se está funcionando

### Teste rápido no container:

```bash
# Dentro do container clinica_app
php artisan tinker
```

Depois digite:
```php
DB::connection()->getPdo();
```

Se retornar algo como `PDO Object`, está conectado! ✅

---

## ❌ Problemas Comuns

### Erro: "Access denied"
- Verifique usuário/senha no `.env`
- Certifique-se de que o usuário tem permissões (`GRANT ALL PRIVILEGES`)

### Erro: "Connection refused"
- MySQL do XAMPP está rodando?
- `DB_HOST=host.docker.internal` está correto?
- Firewall do Windows não está bloqueando?

### Erro: "Unknown database"
- O banco `clinica` existe no MySQL?
- Crie o banco no phpMyAdmin se necessário:
  ```sql
  CREATE DATABASE clinica;
  ```

---

## 🎯 Resumo Rápido

1. ✅ `.env` com `DB_HOST=host.docker.internal`
2. ✅ MySQL do XAMPP rodando
3. ✅ Usuário MySQL com permissões para `%` (qualquer host)
4. ✅ Containers reiniciados
5. ✅ Rodar `php artisan migrate`

**Pronto!** 🎉

