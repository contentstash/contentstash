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

  type FormSchemaInputEnum = {
    type: "enum";
    options: string[];
    defaultValue?: string;
  } & FormSchemaBaseInput;

  type FormSchemaInputArray = {
    type: "array";
    items: FormSchemaInput;
    defaultValue?: unkown[];
  } & FormSchemaBaseInput;

  type FormSchemaInput =
    | FormSchemaInputString
    | FormSchemaInputNumber
    | FormSchemaInputBoolean
    | FormSchemaInputDate
    | FormSchemaInputEnum
    | FormSchemaInputArray;

  type FormSchema = {
    [key: string]: FormSchemaInput;
  };
}
