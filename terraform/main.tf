# Definicja VPC
resource "aws_vpc" "main_vpc" {
  cidr_block = "10.0.0.0/16"
}

# Definicja Subnetu
resource "aws_subnet" "main_subnet_1" {
  vpc_id            = aws_vpc.main_vpc.id
  cidr_block        = "10.0.1.0/24"
  availability_zone = "eu-north-1a"
}

resource "aws_subnet" "main_subnet_2" {
  vpc_id            = aws_vpc.main_vpc.id
  cidr_block        = "10.0.2.0/24"  # Zmieniono CIDR na unikalny
  availability_zone = "eu-north-1b"
}

# Definicja bramy internetowej
resource "aws_internet_gateway" "main_gw" {
  vpc_id = aws_vpc.main_vpc.id
}

# Definicja grupy bezpieczeństwa dla ECS
resource "aws_security_group" "ecs_sg" {
  vpc_id = aws_vpc.main_vpc.id

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 5432
    to_port     = 5432
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

# Definicja klastra ECS
resource "aws_ecs_cluster" "main_cluster" {
  name = "main-cluster"
}

# Rola IAM dla ECS Task Execution
resource "aws_iam_role" "ecs_task_execution_role" {
  name = "ecsTaskExecutionRole"

  assume_role_policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action = "sts:AssumeRole"
        Effect = "Allow"
        Principal = {
          Service = "ecs-tasks.amazonaws.com"
        }
      }
    ]
  })
}

# Polityki przypisane do roli ECS Task Execution
resource "aws_iam_role_policy_attachment" "ecs_task_execution_policy" {
  role       = aws_iam_role.ecs_task_execution_role.name
  policy_arn = "arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy"
}

# Rola IAM dla ECS Task Role (jeśli potrzebujesz dodatkowych uprawnień dla kontenerów)
resource "aws_iam_role" "ecs_task_role" {
  name = "ecsTaskRole"

  assume_role_policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action = "sts:AssumeRole"
        Effect = "Allow"
        Principal = {
          Service = "ecs-tasks.amazonaws.com"
        }
      }
    ]
  })
}

# Polityki przypisane do ECS Task Role (przykład, jeśli chcesz dodać specyficzne uprawnienia)
resource "aws_iam_role_policy_attachment" "ecs_task_role_policy" {
  role       = aws_iam_role.ecs_task_role.name
  policy_arn = "arn:aws:iam::aws:policy/AmazonS3ReadOnlyAccess" # Przykład: dostęp do S3
}

# Definicja zadania ECS
resource "aws_ecs_task_definition" "app_task" {
  family                = "app-task"
  network_mode          = "awsvpc"

  container_definitions = jsonencode([
    {
      name  = "customer-service"
      image = "path/to/customer-service:image"
      memory = 512
      cpu = 256
    },
    {
      name  = "mail-service"
      image = "path/to/mail-service:image"
      memory = 512
      cpu = 256
    },
    {
      name  = "doctor-service"
      image = "path/to/doctor-service:image"
      memory = 512
      cpu = 256
    },
    {
      name  = "appointment-service"
      image = "path/to/appointment-service:image"
      memory = 512
      cpu = 256
    },
    {
      name  = "patient-service"
      image = "path/to/patient-service:image"
      memory = 512
      cpu = 256
    }
  ])

  requires_compatibilities = ["FARGATE"]
  execution_role_arn       = aws_iam_role.ecs_task_execution_role.arn
  task_role_arn            = aws_iam_role.ecs_task_role.arn
  cpu                      = "1280"  # Zwiększono wartość CPU dla zadania
  memory                   = "4096"
}

# Definicja usługi ECS
resource "aws_ecs_service" "app_service" {
  name            = "app-service"
  cluster         = aws_ecs_cluster.main_cluster.id
  task_definition = aws_ecs_task_definition.app_task.arn
  desired_count   = 1
  launch_type     = "FARGATE"
  network_configuration {
    subnets         = [
      aws_subnet.main_subnet_1.id,
      aws_subnet.main_subnet_2.id
    ]
    security_groups = [aws_security_group.ecs_sg.id]
  }
}

# Definicja klastra RDS Aurora Serverless
resource "aws_rds_cluster" "aurora_cluster" {
  cluster_identifier      = "aurora-cluster"
  engine                  = "aurora-postgresql"
  engine_version          = "11.7"  # Zmiana na dostępna wersję
  master_username         = var.rds_username
  master_password         = var.rds_password
  database_name           = "mydb"
  backup_retention_period = 1
  preferred_backup_window = "07:00-09:00"

  scaling_configuration {
    auto_pause   = true
    min_capacity = var.aurora_min_capacity
    max_capacity = var.aurora_max_capacity
  }
}

# Definicja instancji RDS Aurora
resource "aws_rds_cluster_instance" "aurora_instance" {
  identifier              = "aurora-instance"
  cluster_identifier      = aws_rds_cluster.aurora_cluster.id
  instance_class          = var.rds_instance_class
  engine                  = aws_rds_cluster.aurora_cluster.engine
}

# Definicja grupy bezpieczeństwa dla Aurora
resource "aws_security_group" "aurora_sg" {
  vpc_id = aws_vpc.main_vpc.id

  ingress {
    from_port   = 5432
    to_port     = 5432
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

# Definicja kolejki SQS
resource "aws_sqs_queue" "main_queue" {
  name = "main-queue"
}

# Konfiguracja Route 53 dla domeny
resource "aws_route53_zone" "main" {
  name = var.domain_name
}

# Konfiguracja rekordu DNS dla aplikacji
resource "aws_route53_record" "app_record" {
  zone_id = aws_route53_zone.main.zone_id
  name    = "app.${var.domain_name}"
  type    = "A"

  alias {
    name                   = aws_lb.main.dns_name
    zone_id                = aws_lb.main.zone_id
    evaluate_target_health = true
  }
}

# Definicja Load Balancera (ALB)
resource "aws_lb" "main" {
  name               = "app-lb"
  internal           = false
  load_balancer_type = "application"
  security_groups    = [aws_security_group.ecs_sg.id]
  subnets            = [
    aws_subnet.main_subnet_1.id,
    aws_subnet.main_subnet_2.id
  ]

  enable_deletion_protection = false
}

# Konfiguracja listenera dla Load Balancera
resource "aws_lb_listener" "app_listener" {
  load_balancer_arn = aws_lb.main.arn
  port              = "80"
  protocol          = "HTTP"

  default_action {
    type = "forward"
    target_group_arn = aws_lb_target_group.app_tg.arn
  }
}

# Definicja grupy docelowej dla ECS
resource "aws_lb_target_group" "app_tg" {
  name        = "app-tg"
  port        = 80
  protocol    = "HTTP"
  vpc_id      = aws_vpc.main_vpc.id
  target_type = "ip"
}

# Przypisanie usługi ECS do grupy docelowej
resource "aws_lb_target_group_attachment" "ecs_attachment" {
  target_group_arn = aws_lb_target_group.app_tg.arn
  target_id        = aws_ecs_service.app_service.id
  port             = 80
}
