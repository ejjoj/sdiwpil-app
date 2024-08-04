variable "customer_service_endpoint" {
  description = "The endpoint for the customer service"
  type        = string
}

variable "appointment_service_endpoint" {
  description = "The endpoint for the appointment service"
  type        = string
}

variable "doctor_service_endpoint" {
  description = "The endpoint for the doctor service"
  type        = string
}

variable "patient_service_endpoint" {
  description = "The endpoint for the patient service"
  type        = string
}

variable "ecs_services" {
  description = "Map of ECS service names"
  type        = map(string)
}
