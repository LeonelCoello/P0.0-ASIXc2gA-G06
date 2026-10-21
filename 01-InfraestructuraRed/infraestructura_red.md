# Manual Técnico: Infraestructura y Red

| Documento | Dominio | Alcance |
| :--- | :--- | :--- |
| infraestructura_red.md | AWS EC2 / SSH / Seguridad | Sprint 1 — Despliegue e Infraestructura Base |

---

## 1. Contexto del Sprint 1: Despliegue de Infraestructura y Red
En el marco del Sprint 1, el objetivo de infraestructura consiste en desplegar, asegurar y validar el servidor base en la nube de Amazon Web Services (AWS) para el proyecto EducaBCN, estableciendo las políticas de acceso remoto por SSH, la gestión de usuarios administradores y la integración con el repositorio de GitHub.

---

## 2. Creación y Configuración de la Instancia en AWS EC2

### 2.1 Especificaciones de la Instancia
Se realiza el aprovisionamiento de la máquina virtual en AWS EC2 para el alojamiento central del sistema:

* **Nombre de la instancia:** `B-NCC-App`
* **Sistema Operativo:** Ubuntu Server 24.04 LTS (HVM), SSD Volume Type, arquitectura amd64
* **Identificador AMI:** `ami-0f8a61b66d1accaee`

![Creación de la instancia AWS EC2 B-NCC-App](img/01_aws_instancia.png)

### 2.2 Configuración de Red, Claves y Security Group
Se asignan los parámetros de red y las reglas de seguridad perimetral (*Security Group*) para permitir el acceso administrativo y web:

* **Par de claves SSH:** `claves-educabcn` (`claves-educabcn.pem`)
* **Red / VPC:** `vpc-03b0bf5f9f9c462e3`
* **Reglas de tráfico entrante (*Inbound Rules*):**
  * **SSH (Puerto 22):** Permitido para administración remota (`0.0.0.0/0`)
  * **HTTP (Puerto 80):** Permitido para tráfico web público (`0.0.0.0/0`)
  * **HTTPS (Puerto 443):** Permitido para tráfico web seguro (`0.0.0.0/0`)

![Configuración del par de claves y Security Group en AWS](img/02_security_group_claves.png)

---

## 3. Acceso SSH, Usuario Administrador e Integración con GitHub

### 3.1 Acceso Inicial y Creación del Usuario Administrador (`edbcn_admin`)
Se establece la primera conexión remota mediante la clave privada PEM y se crea el usuario administrador dedicado `edbcn_admin` asignado al grupo `sudo`:

```bash
chmod 400 claves-educabcn.pem
ssh -i claves-educabcn.pem ubuntu@13.217.42.86
sudo useradd -m -s /bin/bash edbcn_admin
sudo passwd edbcn_admin
sudo usermod -aG sudo edbcn_admin
