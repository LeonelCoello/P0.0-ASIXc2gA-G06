# Manual Técnico: Infraestructura y Red

| Documento | Dominio | Alcance |
| :--- | :--- | :--- |
| infraestructura_red.md | AWS EC2 / SSH / Seguridad | Sprint 1 — Despliegue e Infraestructura Base |

---

## 1. Contexto del Sprint 1: Despliegue de Infraestructura y Red
En el marco del Sprint 1, el objetivo de infraestructura consiste en desplegar, asegurar y validar el servidor base en la nube de Amazon Web Services (AWS) para el proyecto EducaBCN, estableciendo las políticas de acceso remoto por SSH, la gestión de usuarios administradores y la integración con el repositorio de GitHub[cite: 1].

---

## 2. Creación y Configuración de la Instancia en AWS EC2

### 2.1 Especificaciones de la Instancia
Se realiza el aprovisionamiento de la máquina virtual en AWS EC2 para el alojamiento central del sistema[cite: 2]:

* **Nombre de la instancia:** `B-NCC-App`[cite: 2].
* **Sistema Operativo:** Ubuntu Server 24.04 LTS (HVM), SSD Volume Type, arquitectura amd64[cite: 2].
* **Identificador AMI:** `ami-0f8a61b66d1accaee`[cite: 2].

![Creación de la instancia AWS EC2 B-NCC-App](img/01_aws_instancia.png)

### 2.2 Configuración de Red, Claves y Security Group
Se asignan los parámetros de red y las reglas de seguridad perimetral (*Security Group*) para permitir el acceso administrativo y web[cite: 3]:

* **Par de claves SSH:** `claves-educabcn` (`claves-educabcn.pem`)[cite: 3].
* **Red / VPC:** `vpc-03b0bf5f9f9c462e3`[cite: 3].
* **Reglas de tráfico entrante (*Inbound Rules*):**
  * **SSH (Puerto 22):** Permitido para administración remota (`0.0.0.0/0`)[cite: 3].
  * **HTTP (Puerto 80):** Permitido para tráfico web público (`0.0.0.0/0`)[cite: 3].
  * **HTTPS (Puerto 443):** Permitido para tráfico web seguro (`0.0.0.0/0`)[cite: 3].

![Configuración del par de claves y Security Group en AWS](img/02_security_group_claves.png)

---

## 3. Acceso SSH, Usuario Administrador e Integración con GitHub

### 3.1 Acceso Inicial y Creación del Usuario Administrador (`edbcn_admin`)
Se establece la primera conexión remota mediante la clave privada PEM y se crea el usuario administrador dedicado `edbcn_admin` asignado al grupo `sudo`[cite: 4]:

```bash
chmod 400 claves-educabcn.pem
ssh -i claves-educabcn.pem ubuntu@13.217.42.86
sudo useradd -m -s /bin/bash edbcn_admin
sudo passwd edbcn_admin
sudo usermod -aG sudo edbcn_admin
```[cite: 4]

![Conexión SSH inicial y alta del usuario edbcn_admin](img/03_ssh_login_edbcn_admin.png)

### 3.2 Generación de Claves SSH e Integración con GitHub
Desde la cuenta del usuario `edbcn_admin` se instala el cliente `git` y se genera un par de claves SSH (`ed25519`) para vincular el servidor con el repositorio de GitHub mediante una Deploy Key[cite: 5]:

```bash
sudo apt install git -y
ssh-keygen -t ed25519 -C "edbcn"
cat ~/.ssh/id_ed25519.pub
```[cite: 5]

La clave pública obtenida se registra en las *Deploy Keys* del repositorio bajo el nombre `EC2 EducaBCN`[cite: 5].

![Generación de clave SSH ed25519 e integración en GitHub Deploy Keys](img/04_git_deploy_keys.png)

### 3.3 Validación de Conexión SSH y Pruebas con el Repositorio
Se verifica la comunicación bidireccional con GitHub y se clona el repositorio en la instancia, realizando una modificación y enviando un commit de prueba (`Prueba de pull en EC2`)[cite: 6]:

```bash
ssh -T git@github.com
git clone git@github.com:LeonelCoello/P0.0-ASIXc2gA-G06.git
cd P0.0-ASIXc2gA-G06
git config user.name "Oussama Boukhali"
echo "Prueba pull en EC2" >> README.md
git add README.md
git commit -m "Prueba de pull en EC2"
git push
```[cite: 6]

![Clonación del repositorio y ejecución de commit y push desde la EC2](img/05_git_clone_pull_test.png)

Se confirma en la interfaz web de GitHub la correcta sincronización del commit y la estructura modular de carpetas (`01` a `06`)[cite: 7]:

![Verificación de la estructura del repositorio y commit en GitHub](img/06_github_commit_verification.png)

---

## 4. Creación del Usuario Auditor (`bchecker`) y Habilitación SSH

### 4.1 Alta de Usuario y Configuración de Autenticación por Contraseña
Se crea el usuario auditor `bchecker` con acceso a `sudo`[cite: 8]. Para posibilitar la autenticación remota por contraseña desde ubicaciones autorizadas, se ajusta la directiva en `/etc/ssh/sshd_config` y se reinicia el servicio SSH[cite: 8]:

```bash
sudo adduser bchecker
sudo usermod -aG sudo bchecker
```[cite: 8]

Configuración aplicada en `/etc/ssh/sshd_config`[cite: 8]:
```text
PasswordAuthentication yes
```[cite: 8]

Reinicio del servicio para activar los cambios[cite: 8]:
```bash
sudo systemctl restart ssh
```[cite: 8]

![Alta del usuario bchecker y modificación de sshd_config](img/07_bchecker_creation_sshd_config.png)

### 4.2 Verificación del Acceso Remoto
Se efectúa una prueba de inicio de sesión SSH autenticada por contraseña con el usuario `bchecker` y se ejecuta el comando `whoami` para verificar la identidad en el sistema[cite: 9]:

```bash
ssh bchecker@13.217.42.86
whoami
```[cite: 9]

Resultado devuelto por la consola remota[cite: 9]:
```text
bchecker
```[cite: 9]

![Comprobación del inicio de sesión SSH con el usuario bchecker](img/08_bchecker_ssh_verification.png)
