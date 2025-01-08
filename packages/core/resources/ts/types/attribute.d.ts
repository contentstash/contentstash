export {};

declare global {
  type AttributeTypeClasses = {
    badge?: string;
    [key: string]: string;
  };

  enum AttributeTypeFormat {
    Date = "DATE",
    DateTime = "DATETIME",
    Raw = "RAW",
    Time = "TIME",
  }

  type AttributeType = {
    name: string;
    phpType: string;
    type: string;
    icon?: string;
    classes?: AttributeTypeClasses;
    format: AttributeTypeFormat;
    migration: string;
    cast?: string;
    formSchema: FormSchema;
    additional_attributes: Record<string, unknown>;
  };
}
