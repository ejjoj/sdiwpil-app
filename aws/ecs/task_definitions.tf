resource "aws_ecs_task_definition" "customer_task" {
    family                   = "customer-service"
    network_mode             = "awsvpc"
    requires_compatibilities = ["FARGATE"]
    cpu                      = "256"
    memory                   = "512"
    execution_role_arn       = var.task_execution_role_arn
    task_role_arn            = var.task_role_arn

    container_definitions = jsonencode([
        {
            name      = "customer-service"
            image     = "your-dockerhub-username/customer-service:latest"
            essential = true
            portMappings = [
                {
                    containerPort = 80
                    hostPort      = 80
                }
            ]
        }
    ])
}

resource "aws_ecs_task_definition" "appointment_task" {
    family                   = "appointment-service"
    network_mode             = "awsvpc"
    requires_compatibilities = ["FARGATE"]
    cpu                      = "256"
    memory                   = "512"
    execution_role_arn       = var.task_execution_role_arn
    task_role_arn            = var.task_role_arn

    container_definitions = jsonencode([
        {
            name      = "appointment-service"
            image     = "your-dockerhub-username/appointment-service:latest"
            essential = true
            portMappings = [
                {
                    containerPort = 80
                    hostPort      = 80
                }
            ]
        }
    ])
}

resource "aws_ecs_task_definition" "doctor_task" {
    family                   = "doctor-service"
    network_mode             = "awsvpc"
    requires_compatibilities = ["FARGATE"]
    cpu                      = "256"
    memory                   = "512"
    execution_role_arn       = var.task_execution_role_arn
    task_role_arn            = var.task_role_arn

    container_definitions = jsonencode([
        {
            name      = "doctor-service"
            image     = "your-dockerhub-username/doctor-service:latest"
            essential = true
            portMappings = [
                {
                    containerPort = 80
                    hostPort      = 80
                }
            ]
        }
    ])
}

resource "aws_ecs_task_definition" "patient_task" {
    family                   = "patient-service"
    network_mode             = "awsvpc"
    requires_compatibilities = ["FARGATE"]
    cpu                      = "256"
    memory                   = "512"
    execution_role_arn       = var.task_execution_role_arn
    task_role_arn            = var.task_role_arn

    container_definitions = jsonencode([
        {
            name      = "patient-service"
            image     = "your-dockerhub-username/patient-service:latest"
            essential = true
            portMappings = [
                {
                    containerPort = 80
                    hostPort      = 80
                }
            ]
        }
    ])
}
