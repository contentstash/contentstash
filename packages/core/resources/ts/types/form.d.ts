export {};

declare global {
  type FormSchemaBaseInput = {
    label: string;
    description?: string;
    placeholder?: string;
    required?: boolean;
    component?: string;
  };

  type FormSchemaInputString = {
    type: "string";
    defaultValue?: string;
  } & FormSchemaBaseInput;

  type FormSchemaInputJson = Exclude<FormSchemaInputString, "type"> & {
    type: "json";
  };

  type FormSchemaInputNumber = {
    type: "number";
    defaultValue?: number;
    min?: number;
    max?: number;
  } & FormSchemaBaseInput;

  type FormSchemaInputBoolean = {
    type: "boolean";
    defaultValue?: boolean;
  } & FormSchemaBaseInput;

  type FormSchemaInputDate = {
    type: "date";
    defaultValue?: string | Date;
  } & FormSchemaBaseInput;

  type FormSchemaInput =
    | FormSchemaInputString
    | FormSchemaInputJson
    | FormSchemaInputNumber
    | FormSchemaInputBoolean
    | FormSchemaInputDate;

  type FormSchema = {
    [key: string]: FormSchemaInput;
  };
}
