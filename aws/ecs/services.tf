resource "aws_ecs_service" "customer_service" {
    name            = "customer-service"
    cluster         = aws_ecs_cluster.main.id
    task_definition = aws_ecs_task_definition.customer_task.arn
    desired_count   = 1
    launch_type     = "FARGATE"

    network_configuration {
        subnets         = var.subnet_ids
        security_groups = [aws_security_group.ecs_service.id]
    }
}

resource "aws_ecs_service" "appointment_service" {
    name            = "appointment-service"
    cluster         = aws_ecs_cluster.main.id
    task_definition = aws_ecs_task_definition.appointment_task.arn
    desired_count   = 1
    launch_type     = "FARGATE"

    network_configuration {
        subnets         = var.subnet_ids
        security_groups = [aws_security_group.ecs_service.id]
    }
}

resource "aws_ecs_service" "doctor_service" {
    name            = "doctor-service"
    cluster         = aws_ecs_cluster.main.id
    task_definition = aws_ecs_task_definition.doctor_task.arn
    desired_count   = 1
    launch_type     = "FARGATE"

    network_configuration {
        subnets         = var.subnet_ids
        security_groups = [aws_security_group.ecs_service.id]
    }
}

resource "aws_ecs_service" "patient_service" {
    name            = "doctor-service"
    cluster         = aws_ecs_cluster.main.id
    task_definition = aws_ecs_task_definition.patient_task.arn
    desired_count   = 1
    launch_type     = "FARGATE"

    network_configuration {
        subnets         = var.subnet_ids
        security_groups = [aws_security_group.ecs_service.id]
    }
}

resource "aws_security_group" "ecs_service" {
    name        = "ecs-service-sg"
    vpc_id      = var.vpc_id

    ingress {
        from_port   = 80
        to_port     = 80
        protocol    = "tcp"
        cidr_blocks = ["0.0.0.0/0"]
    }

    egress {
        from_port   = 0
        to_port     = 0
        protocol    = "-1"
        cidr_blocks = ["0.0.0.0/0"]
    }
}
