import type {
  OpenAPIClient,
  Parameters,
  UnknownParamsObject,
  OperationResponse,
  AxiosRequestConfig,
} from 'openapi-client-axios';

declare namespace Components {
    namespace Responses {
        export interface ModelNotFoundException {
            /**
             * Error overview.
             */
            message: string;
        }
        export interface ValidationException {
            /**
             * Errors overview.
             */
            message: string;
            /**
             * A detailed description of each field that failed validation.
             */
            errors: {
                [name: string]: string[];
            };
        }
    }
    namespace Schemas {
        /**
         * AppointmentResource
         */
        export interface AppointmentResource {
            id: number;
            uuid: string;
            customer_email: string;
            customer_phone_number: string | null;
            health_professional_id: number;
            service_id: number;
            start_date_time: string; // date-time
            end_date_time: string; // date-time
            confirmed: boolean;
            created_at: string | null; // date-time
            updated_at: string | null; // date-time
        }
        /**
         * AppointmentTypeEnum
         */
        export type AppointmentTypeEnum = "initial" | "follow_up" | "control" | "emergency";
        /**
         * GenericEnumResource
         */
        export interface GenericEnumResource {
            value: string;
            title: string;
        }
        /**
         * HealthProfessionalResource
         */
        export interface HealthProfessionalResource {
            id: number;
            title: string;
            subtitle: string;
            created_at: string | null; // date-time
            updated_at: string | null; // date-time
        }
        /**
         * ProfessionalTypeEnum
         */
        export type ProfessionalTypeEnum = "general_doctor" | "cardiologist" | "dermatologist" | "gynecologist" | "pediatrician" | "surgeon" | "psychotherapist" | "physiotherapist";
        /**
         * ServiceResource
         */
        export interface ServiceResource {
            id: number;
            name: string;
            description: string;
            subtitle: string;
            created_at: string | null; // date-time
            updated_at: string | null; // date-time
        }
        /**
         * ServiceTypeEnum
         */
        export type ServiceTypeEnum = "consultation" | "diagnostics" | "procedure" | "therapy" | "surgery";
        /**
         * StoreAppointmentRequest
         */
        export interface StoreAppointmentRequest {
            customer_email: string; // email
            customer_phone_number?: string | null;
            start_date_time: string; // date-time
            end_date_time: string; // date-time
            visit_format: /* VisitFormatEnum */ VisitFormatEnum;
            appointment_type: /* AppointmentTypeEnum */ AppointmentTypeEnum;
            service_id: number;
            health_professional_id: number;
        }
        /**
         * StoreHealthProfessionalRequest
         */
        export interface StoreHealthProfessionalRequest {
            name: string;
            type: /* ProfessionalTypeEnum */ ProfessionalTypeEnum;
        }
        /**
         * StoreServiceRequest
         */
        export interface StoreServiceRequest {
            name: string;
            description: string;
            type: /* ServiceTypeEnum */ ServiceTypeEnum;
        }
        /**
         * UpdateAppointmentRequest
         */
        export interface UpdateAppointmentRequest {
            customer_email?: string; // email
            customer_phone_number?: string | null;
            health_professional_id?: number;
            service_id?: number;
            start_date_time?: string; // date-time
            end_date_time?: string; // date-time
            visit_format?: /* VisitFormatEnum */ VisitFormatEnum;
            appointment_type?: /* AppointmentTypeEnum */ AppointmentTypeEnum;
            confirmed?: boolean;
        }
        /**
         * UpdateHealthProfessionalRequest
         */
        export interface UpdateHealthProfessionalRequest {
            name?: string;
            type?: /* ProfessionalTypeEnum */ ProfessionalTypeEnum;
        }
        /**
         * UpdateServiceRequest
         */
        export interface UpdateServiceRequest {
            name?: string;
            description?: string;
            type?: /* ServiceTypeEnum */ ServiceTypeEnum;
        }
        /**
         * VisitFormatEnum
         */
        export type VisitFormatEnum = "in_person" | "telemedicine";
    }
}
declare namespace Paths {
    namespace CreateAppointment {
        export type RequestBody = /* StoreAppointmentRequest */ Components.Schemas.StoreAppointmentRequest;
        namespace Responses {
            export interface $201 {
                data: /* AppointmentResource */ Components.Schemas.AppointmentResource;
            }
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace CreateHealthProfessional {
        export type RequestBody = /* StoreHealthProfessionalRequest */ Components.Schemas.StoreHealthProfessionalRequest;
        namespace Responses {
            export interface $201 {
                data: /* HealthProfessionalResource */ Components.Schemas.HealthProfessionalResource;
            }
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace CreateService {
        export type RequestBody = /* StoreServiceRequest */ Components.Schemas.StoreServiceRequest;
        namespace Responses {
            export interface $201 {
                data: /* ServiceResource */ Components.Schemas.ServiceResource;
            }
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace DeleteAppointment {
        namespace Parameters {
            export type Appointment = number;
        }
        export interface PathParameters {
            appointment: Parameters.Appointment;
        }
        namespace Responses {
            export interface $204 {
            }
            export type $404 = Components.Responses.ModelNotFoundException;
        }
    }
    namespace DeleteHealthProfessional {
        namespace Parameters {
            export type HealthProfessional = number;
        }
        export interface PathParameters {
            healthProfessional: Parameters.HealthProfessional;
        }
        namespace Responses {
            export interface $204 {
            }
            export type $404 = Components.Responses.ModelNotFoundException;
        }
    }
    namespace DeleteService {
        namespace Parameters {
            export type Service = number;
        }
        export interface PathParameters {
            service: Parameters.Service;
        }
        namespace Responses {
            export interface $204 {
            }
            export type $404 = Components.Responses.ModelNotFoundException;
        }
    }
    namespace GetAppointment {
        namespace Parameters {
            export type Appointment = number;
        }
        export interface PathParameters {
            appointment: Parameters.Appointment;
        }
        namespace Responses {
            export interface $200 {
                data: /* AppointmentResource */ Components.Schemas.AppointmentResource;
            }
            export type $404 = Components.Responses.ModelNotFoundException;
        }
    }
    namespace GetAppointmentTypes {
        namespace Responses {
            export interface $200 {
                data: /* GenericEnumResource */ Components.Schemas.GenericEnumResource[];
            }
        }
    }
    namespace GetHealthProfessional {
        namespace Parameters {
            export type HealthProfessional = number;
        }
        export interface PathParameters {
            healthProfessional: Parameters.HealthProfessional;
        }
        namespace Responses {
            export interface $200 {
                data: /* HealthProfessionalResource */ Components.Schemas.HealthProfessionalResource;
            }
            export type $404 = Components.Responses.ModelNotFoundException;
        }
    }
    namespace GetProfessionalTypes {
        namespace Responses {
            export interface $200 {
                data: /* GenericEnumResource */ Components.Schemas.GenericEnumResource[];
            }
        }
    }
    namespace GetService {
        namespace Parameters {
            export type Service = number;
        }
        export interface PathParameters {
            service: Parameters.Service;
        }
        namespace Responses {
            export interface $200 {
                data: /* ServiceResource */ Components.Schemas.ServiceResource;
            }
            export type $404 = Components.Responses.ModelNotFoundException;
        }
    }
    namespace GetServiceTypes {
        namespace Parameters {
            export type Type = /* ServiceTypeEnum */ Components.Schemas.ServiceTypeEnum;
            export type VisitType = string;
        }
        export interface QueryParameters {
            type?: Parameters.Type;
            visit_type?: Parameters.VisitType;
        }
        namespace Responses {
            export interface $200 {
                data: /* GenericEnumResource */ Components.Schemas.GenericEnumResource[];
            }
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace GetVisitTypes {
        namespace Responses {
            export interface $200 {
                data: /* GenericEnumResource */ Components.Schemas.GenericEnumResource[];
            }
        }
    }
    namespace ListAppointments {
        namespace Responses {
            export interface $200 {
                data: /* AppointmentResource */ Components.Schemas.AppointmentResource[];
                links: {
                    first: string | null;
                    last: string | null;
                    prev: string | null;
                    next: string | null;
                };
                meta: {
                    current_page: number;
                    from: number | null;
                    last_page: number;
                    /**
                     * Generated paginator links.
                     */
                    links: {
                        url: string | null;
                        label: string;
                        active: boolean;
                    }[];
                    /**
                     * Base path for paginator generated URLs.
                     */
                    path: string | null;
                    /**
                     * Number of items shown per page.
                     */
                    per_page: number;
                    /**
                     * Number of the last item in the slice.
                     */
                    to: number | null;
                    /**
                     * Total number of items being paginated.
                     */
                    total: number;
                };
            }
        }
    }
    namespace ListHealthProfessionals {
        namespace Parameters {
            export type Type = /* ProfessionalTypeEnum */ Components.Schemas.ProfessionalTypeEnum;
        }
        export interface QueryParameters {
            type?: Parameters.Type;
        }
        namespace Responses {
            export interface $200 {
                data: /* HealthProfessionalResource */ Components.Schemas.HealthProfessionalResource[];
                links: {
                    first: string | null;
                    last: string | null;
                    prev: string | null;
                    next: string | null;
                };
                meta: {
                    current_page: number;
                    from: number | null;
                    last_page: number;
                    /**
                     * Generated paginator links.
                     */
                    links: {
                        url: string | null;
                        label: string;
                        active: boolean;
                    }[];
                    /**
                     * Base path for paginator generated URLs.
                     */
                    path: string | null;
                    /**
                     * Number of items shown per page.
                     */
                    per_page: number;
                    /**
                     * Number of the last item in the slice.
                     */
                    to: number | null;
                    /**
                     * Total number of items being paginated.
                     */
                    total: number;
                };
            }
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace ListServices {
        namespace Parameters {
            export type Type = /* ServiceTypeEnum */ Components.Schemas.ServiceTypeEnum;
        }
        export interface QueryParameters {
            type?: Parameters.Type;
        }
        namespace Responses {
            export interface $200 {
                data: /* ServiceResource */ Components.Schemas.ServiceResource[];
                links: {
                    first: string | null;
                    last: string | null;
                    prev: string | null;
                    next: string | null;
                };
                meta: {
                    current_page: number;
                    from: number | null;
                    last_page: number;
                    /**
                     * Generated paginator links.
                     */
                    links: {
                        url: string | null;
                        label: string;
                        active: boolean;
                    }[];
                    /**
                     * Base path for paginator generated URLs.
                     */
                    path: string | null;
                    /**
                     * Number of items shown per page.
                     */
                    per_page: number;
                    /**
                     * Number of the last item in the slice.
                     */
                    to: number | null;
                    /**
                     * Total number of items being paginated.
                     */
                    total: number;
                };
            }
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace UpdateAppointment {
        namespace Parameters {
            export type Appointment = number;
        }
        export interface PathParameters {
            appointment: Parameters.Appointment;
        }
        export type RequestBody = /* UpdateAppointmentRequest */ Components.Schemas.UpdateAppointmentRequest;
        namespace Responses {
            export interface $200 {
                data: /* AppointmentResource */ Components.Schemas.AppointmentResource;
            }
            export type $404 = Components.Responses.ModelNotFoundException;
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace UpdateHealthProfessional {
        namespace Parameters {
            export type HealthProfessional = number;
        }
        export interface PathParameters {
            healthProfessional: Parameters.HealthProfessional;
        }
        export type RequestBody = /* UpdateHealthProfessionalRequest */ Components.Schemas.UpdateHealthProfessionalRequest;
        namespace Responses {
            export interface $200 {
                data: /* HealthProfessionalResource */ Components.Schemas.HealthProfessionalResource;
            }
            export type $404 = Components.Responses.ModelNotFoundException;
            export type $422 = Components.Responses.ValidationException;
        }
    }
    namespace UpdateService {
        namespace Parameters {
            export type Service = number;
        }
        export interface PathParameters {
            service: Parameters.Service;
        }
        export type RequestBody = /* UpdateServiceRequest */ Components.Schemas.UpdateServiceRequest;
        namespace Responses {
            export interface $200 {
                data: /* ServiceResource */ Components.Schemas.ServiceResource;
            }
            export type $404 = Components.Responses.ModelNotFoundException;
            export type $422 = Components.Responses.ValidationException;
        }
    }
}


export interface OperationMethods {
  /**
   * listAppointments - List paginated appointments ordered by most recent
   * 
   * Returns a paginated collection of appointments. Useful for building
   * lists, tables, or infinite scrolls on the client.
   */
  'listAppointments'(
    parameters?: Parameters<UnknownParamsObject> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.ListAppointments.Responses.$200>
  /**
   * createAppointment - Create a new appointment
   * 
   * Accepts validated appointment data and creates a new appointment
   * record. Returns the created resource.
   */
  'createAppointment'(
    parameters?: Parameters<UnknownParamsObject> | null,
    data?: Paths.CreateAppointment.RequestBody,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.CreateAppointment.Responses.$201>
  /**
   * getAppointment - Get a single appointment by ID
   * 
   * Returns the appointment resource for the provided identifier.
   */
  'getAppointment'(
    parameters?: Parameters<Paths.GetAppointment.PathParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.GetAppointment.Responses.$200>
  /**
   * updateAppointment - Update an existing appointment
   * 
   * Applies the provided validated data to the specified appointment
   * and returns the updated resource.
   */
  'updateAppointment'(
    parameters?: Parameters<Paths.UpdateAppointment.PathParameters> | null,
    data?: Paths.UpdateAppointment.RequestBody,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.UpdateAppointment.Responses.$200>
  /**
   * deleteAppointment - Delete an appointment
   * 
   * Permanently removes the specified appointment and returns an empty
   * 204 No Content response on success.
   */
  'deleteAppointment'(
    parameters?: Parameters<Paths.DeleteAppointment.PathParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.DeleteAppointment.Responses.$204>
  /**
   * getVisitTypes - Get list of visit types
   */
  'getVisitTypes'(
    parameters?: Parameters<UnknownParamsObject> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.GetVisitTypes.Responses.$200>
  /**
   * getAppointmentTypes - Get list of appointment types
   */
  'getAppointmentTypes'(
    parameters?: Parameters<UnknownParamsObject> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.GetAppointmentTypes.Responses.$200>
  /**
   * getProfessionalTypes - Get list of professional types
   */
  'getProfessionalTypes'(
    parameters?: Parameters<UnknownParamsObject> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.GetProfessionalTypes.Responses.$200>
  /**
   * getServiceTypes - Get list of service types
   */
  'getServiceTypes'(
    parameters?: Parameters<Paths.GetServiceTypes.QueryParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.GetServiceTypes.Responses.$200>
  /**
   * listHealthProfessionals - List paginated health professionals ordered by most recent
   * 
   * Returns a paginated collection of health professionals for use in
   * lists, tables, or infinite scrolling UIs.
   */
  'listHealthProfessionals'(
    parameters?: Parameters<Paths.ListHealthProfessionals.QueryParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.ListHealthProfessionals.Responses.$200>
  /**
   * createHealthProfessional - Create a new health professional
   * 
   * Accepts validated data and creates a new health professional record.
   * Returns the created resource.
   */
  'createHealthProfessional'(
    parameters?: Parameters<UnknownParamsObject> | null,
    data?: Paths.CreateHealthProfessional.RequestBody,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.CreateHealthProfessional.Responses.$201>
  /**
   * getHealthProfessional - Get a single health professional by ID
   * 
   * Returns the health professional resource for the provided identifier.
   */
  'getHealthProfessional'(
    parameters?: Parameters<Paths.GetHealthProfessional.PathParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.GetHealthProfessional.Responses.$200>
  /**
   * updateHealthProfessional - Update an existing health professional
   * 
   * Applies validated changes to the specified health professional and
   * returns the updated resource.
   */
  'updateHealthProfessional'(
    parameters?: Parameters<Paths.UpdateHealthProfessional.PathParameters> | null,
    data?: Paths.UpdateHealthProfessional.RequestBody,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.UpdateHealthProfessional.Responses.$200>
  /**
   * deleteHealthProfessional - Delete a health professional
   * 
   * Permanently removes the specified health professional and returns a
   * 204 No Content response on success.
   */
  'deleteHealthProfessional'(
    parameters?: Parameters<Paths.DeleteHealthProfessional.PathParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.DeleteHealthProfessional.Responses.$204>
  /**
   * listServices - List paginated services ordered by most recent
   * 
   * Returns a paginated collection of services suitable for lists,
   * tables, or infinite scroll views.
   */
  'listServices'(
    parameters?: Parameters<Paths.ListServices.QueryParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.ListServices.Responses.$200>
  /**
   * createService - Create a new service
   * 
   * Accepts validated data and creates a new service record. Returns
   * the created resource.
   */
  'createService'(
    parameters?: Parameters<UnknownParamsObject> | null,
    data?: Paths.CreateService.RequestBody,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.CreateService.Responses.$201>
  /**
   * getService - Get a single service by ID
   * 
   * Returns the service resource for the provided identifier.
   */
  'getService'(
    parameters?: Parameters<Paths.GetService.PathParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.GetService.Responses.$200>
  /**
   * updateService - Update an existing service
   * 
   * Applies validated changes to the specified service and returns the
   * updated resource.
   */
  'updateService'(
    parameters?: Parameters<Paths.UpdateService.PathParameters> | null,
    data?: Paths.UpdateService.RequestBody,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.UpdateService.Responses.$200>
  /**
   * deleteService - Delete a service
   * 
   * Permanently removes the specified service and returns a 204 No
   * Content response on success.
   */
  'deleteService'(
    parameters?: Parameters<Paths.DeleteService.PathParameters> | null,
    data?: any,
    config?: AxiosRequestConfig  
  ): OperationResponse<Paths.DeleteService.Responses.$204>
}

export interface PathsDictionary {
  ['/api/appointments']: {
    /**
     * listAppointments - List paginated appointments ordered by most recent
     * 
     * Returns a paginated collection of appointments. Useful for building
     * lists, tables, or infinite scrolls on the client.
     */
    'get'(
      parameters?: Parameters<UnknownParamsObject> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.ListAppointments.Responses.$200>
    /**
     * createAppointment - Create a new appointment
     * 
     * Accepts validated appointment data and creates a new appointment
     * record. Returns the created resource.
     */
    'post'(
      parameters?: Parameters<UnknownParamsObject> | null,
      data?: Paths.CreateAppointment.RequestBody,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.CreateAppointment.Responses.$201>
  }
  ['/api/appointments/{appointment}']: {
    /**
     * getAppointment - Get a single appointment by ID
     * 
     * Returns the appointment resource for the provided identifier.
     */
    'get'(
      parameters?: Parameters<Paths.GetAppointment.PathParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.GetAppointment.Responses.$200>
    /**
     * updateAppointment - Update an existing appointment
     * 
     * Applies the provided validated data to the specified appointment
     * and returns the updated resource.
     */
    'put'(
      parameters?: Parameters<Paths.UpdateAppointment.PathParameters> | null,
      data?: Paths.UpdateAppointment.RequestBody,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.UpdateAppointment.Responses.$200>
    /**
     * deleteAppointment - Delete an appointment
     * 
     * Permanently removes the specified appointment and returns an empty
     * 204 No Content response on success.
     */
    'delete'(
      parameters?: Parameters<Paths.DeleteAppointment.PathParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.DeleteAppointment.Responses.$204>
  }
  ['/api/visit-types']: {
    /**
     * getVisitTypes - Get list of visit types
     */
    'get'(
      parameters?: Parameters<UnknownParamsObject> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.GetVisitTypes.Responses.$200>
  }
  ['/api/appointment-types']: {
    /**
     * getAppointmentTypes - Get list of appointment types
     */
    'get'(
      parameters?: Parameters<UnknownParamsObject> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.GetAppointmentTypes.Responses.$200>
  }
  ['/api/professional-types']: {
    /**
     * getProfessionalTypes - Get list of professional types
     */
    'get'(
      parameters?: Parameters<UnknownParamsObject> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.GetProfessionalTypes.Responses.$200>
  }
  ['/api/service-types']: {
    /**
     * getServiceTypes - Get list of service types
     */
    'get'(
      parameters?: Parameters<Paths.GetServiceTypes.QueryParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.GetServiceTypes.Responses.$200>
  }
  ['/api/health-professionals']: {
    /**
     * listHealthProfessionals - List paginated health professionals ordered by most recent
     * 
     * Returns a paginated collection of health professionals for use in
     * lists, tables, or infinite scrolling UIs.
     */
    'get'(
      parameters?: Parameters<Paths.ListHealthProfessionals.QueryParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.ListHealthProfessionals.Responses.$200>
    /**
     * createHealthProfessional - Create a new health professional
     * 
     * Accepts validated data and creates a new health professional record.
     * Returns the created resource.
     */
    'post'(
      parameters?: Parameters<UnknownParamsObject> | null,
      data?: Paths.CreateHealthProfessional.RequestBody,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.CreateHealthProfessional.Responses.$201>
  }
  ['/api/health-professionals/{healthProfessional}']: {
    /**
     * getHealthProfessional - Get a single health professional by ID
     * 
     * Returns the health professional resource for the provided identifier.
     */
    'get'(
      parameters?: Parameters<Paths.GetHealthProfessional.PathParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.GetHealthProfessional.Responses.$200>
    /**
     * updateHealthProfessional - Update an existing health professional
     * 
     * Applies validated changes to the specified health professional and
     * returns the updated resource.
     */
    'put'(
      parameters?: Parameters<Paths.UpdateHealthProfessional.PathParameters> | null,
      data?: Paths.UpdateHealthProfessional.RequestBody,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.UpdateHealthProfessional.Responses.$200>
    /**
     * deleteHealthProfessional - Delete a health professional
     * 
     * Permanently removes the specified health professional and returns a
     * 204 No Content response on success.
     */
    'delete'(
      parameters?: Parameters<Paths.DeleteHealthProfessional.PathParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.DeleteHealthProfessional.Responses.$204>
  }
  ['/api/services']: {
    /**
     * listServices - List paginated services ordered by most recent
     * 
     * Returns a paginated collection of services suitable for lists,
     * tables, or infinite scroll views.
     */
    'get'(
      parameters?: Parameters<Paths.ListServices.QueryParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.ListServices.Responses.$200>
    /**
     * createService - Create a new service
     * 
     * Accepts validated data and creates a new service record. Returns
     * the created resource.
     */
    'post'(
      parameters?: Parameters<UnknownParamsObject> | null,
      data?: Paths.CreateService.RequestBody,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.CreateService.Responses.$201>
  }
  ['/api/services/{service}']: {
    /**
     * getService - Get a single service by ID
     * 
     * Returns the service resource for the provided identifier.
     */
    'get'(
      parameters?: Parameters<Paths.GetService.PathParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.GetService.Responses.$200>
    /**
     * updateService - Update an existing service
     * 
     * Applies validated changes to the specified service and returns the
     * updated resource.
     */
    'put'(
      parameters?: Parameters<Paths.UpdateService.PathParameters> | null,
      data?: Paths.UpdateService.RequestBody,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.UpdateService.Responses.$200>
    /**
     * deleteService - Delete a service
     * 
     * Permanently removes the specified service and returns a 204 No
     * Content response on success.
     */
    'delete'(
      parameters?: Parameters<Paths.DeleteService.PathParameters> | null,
      data?: any,
      config?: AxiosRequestConfig  
    ): OperationResponse<Paths.DeleteService.Responses.$204>
  }
}

export type Client = OpenAPIClient<OperationMethods, PathsDictionary>


export type AppointmentResource = Components.Schemas.AppointmentResource;
export type AppointmentTypeEnum = Components.Schemas.AppointmentTypeEnum;
export type GenericEnumResource = Components.Schemas.GenericEnumResource;
export type HealthProfessionalResource = Components.Schemas.HealthProfessionalResource;
export type ProfessionalTypeEnum = Components.Schemas.ProfessionalTypeEnum;
export type ServiceResource = Components.Schemas.ServiceResource;
export type ServiceTypeEnum = Components.Schemas.ServiceTypeEnum;
export type StoreAppointmentRequest = Components.Schemas.StoreAppointmentRequest;
export type StoreHealthProfessionalRequest = Components.Schemas.StoreHealthProfessionalRequest;
export type StoreServiceRequest = Components.Schemas.StoreServiceRequest;
export type UpdateAppointmentRequest = Components.Schemas.UpdateAppointmentRequest;
export type UpdateHealthProfessionalRequest = Components.Schemas.UpdateHealthProfessionalRequest;
export type UpdateServiceRequest = Components.Schemas.UpdateServiceRequest;
export type VisitFormatEnum = Components.Schemas.VisitFormatEnum;
