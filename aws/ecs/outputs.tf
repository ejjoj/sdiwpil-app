output "ecs_cluster_id" {
    value = aws_ecs_cluster.main.id
}

output "ecs_services" {
    value = {
        customer_service = aws_ecs_service.customer_service.name
        appointment_service = aws_ecs_service.appointment_service.name
        doctor_service = aws_ecs_service.doctor_service.name
        patient_service = aws_ecs_service.patient_service.name
    }
}
