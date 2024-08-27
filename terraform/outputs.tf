output "vpc_id" {
  description = "ID utworzonej VPC"
  value       = aws_vpc.main_vpc.id
}

output "subnet_id" {
  description = "ID utworzonego Subnetu"
  value       = aws_subnet.main_subnet.id
}

output "ecs_cluster_name" {
  description = "Nazwa utworzonego klastra ECS"
  value       = aws_ecs_cluster.main_cluster.name
}

output "ecs_service_name" {
  description = "Nazwa usługi ECS"
  value       = aws_ecs_service.app_service.name
}

output "rds_cluster_endpoint" {
  description = "Endpoint bazy danych RDS Aurora"
  value       = aws_rds_cluster.aurora_cluster.endpoint
}

output "rds_cluster_identifier" {
  description = "ID klastra RDS Aurora"
  value       = aws_rds_cluster.aurora_cluster.id
}

output "rds_instance_identifier" {
  description = "ID instancji RDS Aurora"
  value       = aws_rds_cluster_instance.aurora_instance.id
}

output "sqs_queue_url" {
  description = "URL kolejki SQS"
  value       = aws_sqs_queue.main_queue.url
}

output "route53_zone_id" {
  description = "ID strefy hostowanej Route 53"
  value       = aws_route53_zone.main.zone_id
}

output "app_url" {
  description = "URL aplikacji"
  value       = aws_route53_record.app_record.fqdn
}

output "load_balancer_dns" {
  description = "DNS Load Balancera"
  value       = aws_lb.main.dns_name
}
