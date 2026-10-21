# Manual Técnico: Infraestructura y Red (AWS EC2, SSH y Usuarios)

## 1. Creación de la Instancia en AWS EC2
Se realiza el despliegue de la máquina virtual en la plataforma de Amazon Web Services (AWS) para el alojamiento del servidor principal del proyecto EducaBCN.

### 1.1 Configuración de la Instancia
* **Nombre de la instancia:** `B-NCC-App`
* **Sistema Operativo:** Ubuntu Server 24.04 LTS (HVM), SSD Volume Type, arquitectura amd64
* **AMI ID:** `ami-0f8a61b66d1accaee`

![Creación de la instancia AWS EC2 B-NCC-App](img/01_aws_creacion_instancia.png)

### 1.2 Configuración de Red, Claves y Security Group
* **Par de claves (login):** `claves-educabcn.pem`
* **VPC:** `vpc-03b0bf5f9f9c462e3`
* **Reglas de entrada (Security Group):**
  * **SSH (Puerto 22):** Permitido desde cualquier origen (`0.0.0.0/0`)
  * **HTTP (Puerto 80):** Permitido desde cualquier origen (`0.0.0.0/0`)
  * **HTTPS (Puerto 443):** Permitido desde cualquier origen (`0.0.0.0/0`)

![Configuración del par de claves y Security Group en AWS](img/02_security_group_claves.png)

---

## 2. Acceso SSH y Creación del Usuario Administrador (`edbcn_admin`)

### 2.1 Acceso Inicial y Alta del Usuario
Se accede desde el terminal local utilizando la clave privada PEM y se crea el usuario administrador `edbcn_admin`, añadiéndolo al grupo `sudo`:

```bash
chmod 400 claves-educabcn.pem
ssh -i claves-educabcn.pem ubuntu@13.217.42.86
sudo useradd -m -s /bin/bash edbcn_admin
sudo passwd edbcn_admin
sudo usermod -aG sudo edbcn_admin
```

![Conexión SSH y creación del usuario edbcn_admin](img/03_ssh_login_edbcn_admin.png)

### 2.2 Generación de Claves SSH e Integración con GitHub
Desde la cuenta del usuario `edbcn_admin` se instala `git` y se genera un par de claves SSH (`ed25519`) para vincular el servidor con el repositorio mediante una Deploy Key:

```bash
sudo apt install git -y
ssh-keygen -t ed25519 -C "edbcn"
cat ~/.ssh/id_ed25519.pub
```

La clave pública generada se registra en GitHub en la sección de Deploy Keys con la etiqueta `EC2 EducaBCN`.

![Generación de clave SSH e integración en Deploy Keys de GitHub](img/04_git_deploy_keys.png)

### 2.3 Validación de Conexión y Pruebas con el Repositorio
Se verifica la autenticación con GitHub y se realiza la clonación del repositorio, efectuando un commit de prueba (`Prueba de pull en EC2`):

```bash
ssh -T git@github.com
git clone git@github.com:LeonelCoello/P0.0-ASIXc2gA-G06.git
cd P0.0-ASIXc2gA-G06
git config user.name "Oussama Boukhali"
echo "Prueba pull en EC2" >> README.md
git add README.md
git commit -m "Prueba de pull en EC2"
git push
```

![Clonación del repositorio y ejecución de commit/push desde EC2](img/05_git_clone_pull_test.png)

Verificación en el repositorio remoto del commit realizado con éxito:

![Verificación del commit en GitHub](img/06_github_commit_verification.png)

---

## 3. Creación del Usuario Auditor (`bchecker`) y Habilitación SSH

### 3.1 Alta de Usuario y Modificación de Seguridad SSH
Se crea el usuario `bchecker` y se le conceden permisos de administración. Para permitir el acceso mediante contraseña a través de SSH, se modifica la configuración en `/etc/ssh/sshd_config` y se reinicia el servicio:

```bash
sudo adduser bchecker
sudo usermod -aG sudo bchecker
```

En `/etc/ssh/sshd_config`:
```text
PasswordAuthentication yes
```

Aplicación de cambios:
```bash
sudo systemctl restart ssh
```

![Creación del usuario bchecker y modificación de sshd_config](img/07_bchecker_creation_sshd_config.png)

### 3.2 Comprobación de Acceso Remoto
Se valida la autenticación remota por contraseña del usuario `bchecker` e inspección de identidad mediante `whoami`:

```bash
ssh bchecker@13.217.42.86
whoami
```

![Verificación de acceso SSH con el usuario bchecker](img/08_bchecker_ssh_verification.png)
