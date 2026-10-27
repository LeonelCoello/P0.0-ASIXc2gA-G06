# Manual Técnico y Documentación: Infraestructura y Red

| Metadato | Detalle Técnico |
| :--- | :--- |
| **Documento** | `README.md` |
| **Ubicación en Repositorio** | `01-InfraestructuraRed/README.md` |
| **Dominio** | Computación en Nube (AWS EC2) / Redes / Seguridad SSH / Control de Accesos |
| **Sprint** | Sprint 1 — Despliegue de Infraestructura y Servidor Base |
| **Estado** | Operativo y Validado |

---

## 1. Contexto, Objetivos y Planificación 

### 1.1 Objetivos del Módulo
En esta primera fase del proyecto EducaBCN, el objetivo principal radica en el aprovisionamiento, securización y validación del servidor base en la plataforma de Amazon Web Services (AWS EC2). Sobre esta infraestructura se establecen las políticas de acceso remoto cifrado mediante SSH, la segregación de cuentas administrativas y la integración continua con GitHub utilizando claves asimétricas de despliegue (*Deploy Keys*).

### 1.2 Justificación Técnica de la Arquitectura
* **Amazon Web Services (AWS EC2):** Proporciona un entorno IaaS escalable con una disponibilidad garantizada por contrato (SLA > 99.9%), gestión elástica de direccionamiento IP e integración nativa de firewalls perimetrales (Security Groups).
* **Ubuntu Server 24.04 LTS (Noble Numbat):** Distribución Linux de nivel empresarial con soporte extendido de seguridad, estabilidad del kernel y compatibilidad óptima con la pila de servicios web (Apache/Nginx, PHP, MySQL/MariaDB).
* **Criptografía Ed25519:** Elección del algoritmo de curva elíptica para las llaves SSH por su superioridad en tiempo de procesado, firmas más cortas y mayor resistencia criptográfica frente a RSA tradicional.
* **Segregación de Roles:** Aplicación del principio de mínimo privilegio (*Principle of Least Privilege*) mediante la separación de responsabilidades entre el usuario base del proveedor, el administrador de despliegues y el usuario de auditoría externa.

### 1.3 Organización en GitHub y ProofHub
El proyecto sigue una organización modular de directorios en GitHub (`P0.0-ASIXc2gA-G06`) coordinada mediante el tablero Kanban de ProofHub para el seguimiento de sprints y tareas.

![Estructura del repositorio en GitHub y gestión de tareas en ProofHub](img/00_estructura_git_proofhub.png)

---

## 2. Aprovisionamiento de la Instancia AWS EC2 

### 2.1 Ficha Técnica de la Instancia
Se ha instanciado la máquina virtual con los siguientes parámetros de cómputo y sistema:

| Parámetro | Configuración | Propósito Técnico |
| :--- | :--- | :--- |
| **Nombre de la Instancia** | `B-NCC-App` | Identificador único del nodo de aplicación en AWS. |
| **AMI (Sistema Operativo)** | Ubuntu Server 24.04 LTS (`ami-0f8a61b66d1accaee`) | Imagen oficial de Canonical de 64 bits (amd64). |
| **VPC / Subred** | `vpc-03b0bf5f9f9c462e3` | Entorno de red privada virtual aislado. |
| **Dirección IP Pública** | `13.217.42.86` | Punto de entrada público IPv4 para administración y servicio web. |
| **Par de Claves Inicial** | `claves-educabcn.pem` | Credencial inicial para acceso SSH seguro. |

![Aprovisionamiento de la instancia AWS EC2 B-NCC-App](img/01_aws_instancia.png)

### 2.2 Perímetro de Seguridad (Security Group)
La seguridad a nivel de red se gestiona mediante el Security Group `launch-wizard-1`, configurado con filtrado estricto de puertos de entrada (*Inbound Rules*):

| Protocolo | Puerto | Origen (*CIDR*) | Propósito / Servicio |
| :--- | :--- | :--- | :--- |
| **SSH** | `22` | `0.0.0.0/0` | Gestión y administración remota de terminal. |
| **HTTP** | `80` | `0.0.0.0/0` | Tráfico web público no cifrado. |
| **HTTPS** | `443` | `0.0.0.0/0` | Tráfico web público cifrado mediante SSL/TLS. |

![Configuración del par de claves y reglas del Security Group](img/02_security_group_claves.png)

---

## 3. Matriz de Identidades y Gestión de Usuarios 

Se define la siguiente matriz de accesos en el sistema operativo para garantizar trazabilidad y aislamiento de funciones:

| Usuario OS | Autenticación | Permisos Privilegiados | Función Principal |
| :--- | :--- | :--- | :--- |
| `ubuntu` | Clave Privada PEM (`claves-educabcn.pem`) | `sudo` completo | Cuenta inicial por defecto suministrada por AWS EC2. |
| `edbcn_admin` | Clave Privada SSH (`Ed25519`) | `sudo` delegado | Administrador principal. Gestión de despliegues y operaciones Git. |
| `bchecker` | Contraseña SSH | `sudo` delegado | Usuario auditor para verificación remota de la plataforma. |

---

## 4. Configuración SSH y Despliegue con Git 

### 4.1 Alta del Usuario Administrador (`edbcn_admin`)
Tras la conexión inicial con el usuario `ubuntu`, se crea la cuenta administrativa `edbcn_admin` asignándole intérprete Bash y miembros del grupo `sudo`:

```bash
# Ajuste de permisos de la clave PEM en máquina local
chmod 400 claves-educabcn.pem

# Conexión inicial al servidor
ssh -i claves-educabcn.pem ubuntu@13.217.42.86

# Alta del usuario edbcn_admin y asignación de grupo privilegiado
sudo useradd -m -s /bin/bash edbcn_admin
sudo passwd edbcn_admin
sudo usermod -aG sudo edbcn_admin
```

![Conexión SSH inicial y creación del usuario edbcn_admin](img/03_ssh_login_edbcn_admin.png)

### 4.2 Integración Cifrada con GitHub (Deploy Keys)
En la sesión del usuario `edbcn_admin` se instala el cliente `git` y se genera el par de llaves asimétricas `Ed25519`. La clave pública se vincula en el repositorio de GitHub como **Deploy Key** con permisos de escritura bajo el identificador `EC2 EducaBCN`:

```bash
# Instalación del paquete Git
sudo apt update && sudo apt install git -y

# Generación del par de claves Ed25519
ssh-keygen -t ed25519 -C "edbcn"

# Obtención de la clave pública para GitHub
cat ~/.ssh/id_ed25519.pub
```

![Generación de clave SSH ed25519 e integración en Deploy Keys de GitHub](img/04_git_deploy_keys.png)

### 4.3 Validación Operativa de Git
Se comprueba el enlace SSH con los servidores de GitHub, se clona el repositorio en la instancia EC2 y se efectúa una modificación de prueba en el archivo `README.md` sincronizándola mediante `git push`:

```bash
# Comprobación de autenticación con GitHub
ssh -T git@github.com

# Clonación del repositorio
git clone git@github.com:LeonelCoello/P0.0-ASIXc2gA-G06.git
cd P0.0-ASIXc2gA-G06

# Configuración de usuario y commit de prueba
git config user.name "Oussama Boukhali"
echo "Prueba pull en EC2" >> README.md
git add README.md
git commit -m "Prueba de pull en EC2"
git push
```

![Clonación del repositorio y sincronización de commit/push desde la EC2](img/05_git_clone_pull_test.png)

Verificación en la consola web de GitHub que confirma la recepción del commit en la rama principal (`main`):

![Verificación del commit en la interfaz web de GitHub](img/06_github_commit_verification.png)

---

## 5. Habilitación del Usuario Auditor (`bchecker`) 

### 5.1 Creación de Cuenta y Configuración de `sshd_config`
Se crea el usuario `bchecker` con acceso `sudo` y se habilita la autenticación por contraseña en el servicio SSH modificando `/etc/ssh/sshd_config`:

```bash
# Creación del usuario bchecker
sudo adduser bchecker
sudo usermod -aG sudo bchecker
```

Ajuste de la directiva de autenticación en `/etc/ssh/sshd_config`:
```text
PasswordAuthentication yes
```

Reinicio del servicio para aplicar la configuración:
```bash
sudo systemctl restart ssh
```

![Alta del usuario bchecker y modificación de sshd_config](img/07_bchecker_creation_sshd_config.png)

### 5.2 Verificación de Acceso Remoto
Se valida el acceso desde un terminal externo mediante el uso de contraseña y se verifica el nombre de usuario activo mediante `whoami`:

```bash
# Login remoto con usuario bchecker
ssh bchecker@13.217.42.86

# Verificación de identidad
whoami
```

Salida confirmada en consola:
```text
bchecker
```

![Comprobación de acceso SSH y verificación de identidad con bchecker](img/08_bchecker_ssh_verification.png)

---

## 6. Plan de Pruebas y Validación 

| ID Prueba | Descripción | Resultado Esperado | Resultado Real | Estado |
| :--- | :--- | :--- | :--- | :--- |
| **PR-INF-01** | Despliegue EC2 | Instancia activa con IP pública en AWS | IP `13.217.42.86` asignada | **PASS** |
| **PR-INF-02** | Apertura de Puertos | Puertos 22, 80 y 443 abiertos en SG | Reglas aplicadas correctamente | **PASS** |
| **PR-INF-03** | Usuario `edbcn_admin` | Cuenta creada con privilegios `sudo` | Usuario operativo en grupo `sudo` | **PASS** |
| **PR-INF-04** | Deploy Key Git | Autenticación SSH con GitHub válida | Mensaje de bienvenida de GitHub | **PASS** |
| **PR-INF-05** | Operación Git Push | Sincronización exitosa hacia la nube | Commit visualizado en GitHub web | **PASS** |
| **PR-INF-06** | Usuario `bchecker` | Acceso por contraseña vía SSH habilitado | Inicio de sesión y `whoami` validado | **PASS** |
```

---

He generado la estructura completa del archivo `README.md` listo para usarse.

¿Pasamos ahora a trabajar en el siguiente módulo, como **Servicios Web y FTP** (`03-Servicios_Web_FTP`) o **Base de Datos** (`04-Servicios_Base_Datos`)?
