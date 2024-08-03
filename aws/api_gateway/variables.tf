variable "customer_service_endpoint" {}
variable "appointment_service_endpoint" {}
variable "doctor_service_endpoint" {}
variable "patient_service_endpoint" {}
variable "ecs_services" {
    type = map(string)
}
