export interface Order {
    app_id: string;
    billing_address: BillingAddress;
    browser_ip?: any;
    buyer_accepts_marketing: boolean;
    cancel_reason?: any;
    cancelled_at?: any;
    cart_token?: any;
    client_details?: any;
    closed_at?: any;
    contact_email: string;
    created_at: Date;
    currency: string;
    customer: Customer;
    customer_locale?: any;
    discount_codes: any[];
    email: string;
    financial_status: string;
    fulfillments: any[];
    fulfillment_status?: any;
    tags: string;
    gateway: string;
    id: number;
    landing_site?: any;
    line_items: LineItem[];
    location_id?: any;
    name: string;
    note?: any;
    note_attributes: any[];
    number: string;
    order_number: string;
    payment_details?: any;
    payment_gateway_names: string[];
    phone?: any;
    processed_at: ProcessedAt;
    processing_method: string;
    referring_site?: any;
    refunds: any[];
    shipping_address: ShippingAddress;
    shipping_lines: any[];
    source_name: string;
    subtotal_price: string;
    tax_lines: TaxLine[];
    taxes_included: boolean;
    token: string;
    total_discounts: string;
    total_line_items_price: string;
    total_price: string;
    total_price_usd: string;
    total_tax: string;
    total_weight: string;
    updated_at: Date;
    user_id?: any;
    order_status_url: string;
}

export interface BillingAddress {
    address1: string;
    address2?: any;
    city: string;
    company?: any;
    first_name: string;
    last_name: string;
    phone?: any;
    province: string;
    country: string;
    zip: string;
    name: string;
    province_code?: any;
    country_code: string;
    country_name?: any;
}

export interface DefaultAddress {
    address1: string;
    address2?: any;
    city: string;
    company?: any;
    first_name: string;
    last_name: string;
    phone?: any;
    province: string;
    country: string;
    zip: string;
    name: string;
    province_code?: any;
    country_code: string;
    country_name: string;
}

export interface Customer {
    id: number | string;
    accepts_marketing: boolean;
    addresses?: any;
    created_at: Date;
    default_address: DefaultAddress;
    email: string;
    phone?: any;
    first_name: string;
    metafield?: any;
    multipass_identifier?: any;
    last_name: string;
    last_order_id: number;
    last_order_name: string;
    note?: any;
    orders_count: number;
    state: string;
    tags: string;
    tax_exempt: boolean;
    total_spent: string;
    updated_at: Date;
    verified_email: boolean;
}

export interface Property {
    name: string;
    value: string;
}

export interface TaxLine {
    price: string;
    rate: string;
    title: string;
}

export interface LineItem {
    fulfillable_quantity: number;
    fulfillment_service: string;
    fulfillment_status?: any;
    grams: number;
    id: any;
    price: string;
    product_id: any;
    quantity: number;
    requires_shipping: boolean;
    sku: string;
    title: string;
    variant_id: any;
    variant_title: string;
    vendor: string;
    name: string;
    gift_card: boolean;
    properties: Property[];
    taxable: boolean;
    tax_lines: TaxLine[];
    total_discount: string;
}

export interface ProcessedAt {
    date: string;
    timezone_type: number;
    timezone: string;
}

export interface ShippingAddress {
    address1: string;
    address2?: any;
    city: string;
    company?: any;
    first_name: string;
    last_name: string;
    phone?: any;
    province: string;
    country: string;
    zip: string;
    name: string;
    province_code?: any;
    country_code: string;
    country_name?: any;
}
