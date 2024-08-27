variable "aws_region" {
  description = "Region AWS do użycia"
  type        = string
  default     = "eu-north-1"
}

variable "vpc_cidr" {
  description = "CIDR block dla VPC"
  type        = string
  default     = "10.0.0.0/16"
}

variable "subnet_cidr" {
  description = "CIDR block dla Subnetu"
  type        = string
  default     = "10.0.1.0/24"
}

variable "domain_name" {
  description = "Nazwa domeny dla aplikacji"
  type        = string
  default     = "sdiwpil.com"
}

variable "ecs_cpu" {
  description = "Ilość jednostek CPU dla kontenerów ECS"
  type        = number
  default     = 1024
}

variable "ecs_memory" {
  description = "Ilość pamięci (w MB) dla kontenerów ECS"
  type        = number
  default     = 2048
}

variable "rds_username" {
  description = "Nazwa użytkownika dla bazy danych RDS"
  type        = string
  default     = "sdiwpil_user"
}

variable "rds_password" {
  description = "Hasło dla bazy danych RDS"
  type        = string
  default     = "password"
  sensitive   = true
}

variable "rds_instance_class" {
  description = "Klasa instancji dla RDS Aurora"
  type        = string
  default     = "db.t3.micro"
}

variable "aurora_min_capacity" {
  description = "Minimalna pojemność Aurora Serverless"
  type        = number
  default     = 2
}

variable "aurora_max_capacity" {
  description = "Maksymalna pojemność Aurora Serverless"
  type        = number
  default     = 4
}
