variable "vpc_id" {}
variable "subnet_ids" {
    type = list(string)
}

variable "ecs_cluster_id" {}
variable "task_execution_role_arn" {}
variable "task_role_arn" {}
