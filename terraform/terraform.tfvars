aws_region       = "eu-north-1"
vpc_cidr         = "10.0.0.0/16"
subnet_cidr      = "10.0.1.0/24"
domain_name      = "sdiwpil.com"

ecs_cpu          = 1024
ecs_memory       = 2048

rds_username     = "sdiwpil_user"
rds_password     = "strong_password"  # Upewnij się, że hasło jest silne i bezpieczne

rds_instance_class   = "db.t3.micro"

aurora_min_capacity  = 2
aurora_max_capacity  = 4

# terraform apply -var-file="terraform.dev.tfvars"
