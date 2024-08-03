provider "aws" {
    region = "eu-north-1"
}

module "iam" {
    source = "./iam"
    ecs_task_execution_role_name = ""
    ecs_task_role_name = ""
}

module "vpc" {
    source = "./vpc"
}

module "rds" {
    source       = "./rds"
    vpc_id       = module.vpc.vpc_id
    subnet_ids   = module.vpc.public_subnets
}

module "ecs" {
    source           = "./ecs"
    vpc_id           = module.vpc.vpc_id
    subnet_ids       = module.vpc.public_subnets
    ecs_cluster_id   = module.ecs.ecs_cluster_id
    task_execution_role_arn = module.iam.ecs_task_execution_role_arn
    task_role_arn    = module.iam.ecs_task_role_arn
}

module "api_gateway" {
    source           = "./api_gateway"
    ecs_services     = module.ecs.ecs_services
    appointment_service_endpoint = ""
    customer_service_endpoint = ""
    doctor_service_endpoint = ""
    patient_service_endpoint = ""
}

module "rabbitmq" {
    source     = "./rabbitmq"
    subnet_ids = module.vpc.public_subnets
    vpc_id     = module.vpc.vpc_id
}

module "route53" {
    source = "./route53"
    api_gateway_id = module.api_gateway.api_gateway_id
}
