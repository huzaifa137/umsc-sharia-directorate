{{-- Shared design system for every module's View/Edit application modals.
     Originally built for Nikah; included once per page (alongside that
     module's *-actions-modals partial) so every module's preview/edit
     cards look and feel identical. --}}
<style>
                        /* Custom Modal Styling */
                        .modal-content {
                            border-radius: 20px !important;
                            border: none;
                            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                        }

                        .modal-header {
                            background: #00580f;
                            color: white;
                            border-radius: 20px 20px 0 0 !important;
                            padding: 1.5rem 2rem;
                        }

                        .modal-header .btn-close {
                            filter: invert(1);
                            opacity: 0.8;
                        }

                        .modal-header .btn-close:hover {
                            opacity: 1;
                        }

                        .modal-body {
                            padding: 2rem;
                            background: #f8f9fa;
                        }

                        .modal-footer {
                            background: #f8f9fa;
                            border-radius: 0 0 20px 20px;
                            padding: 1rem 2rem;
                        }

                        /* Section Styling */
                        .section-title {
                            color: #4a5568;
                            font-size: 1.1rem;
                            font-weight: 600;
                            margin-bottom: 1rem;
                            padding-bottom: 0.5rem;
                            border-bottom: 2px solid #e2e8f0;
                            position: relative;
                        }

                        .section-title::after {
                            content: '';
                            position: absolute;
                            left: 0;
                            bottom: -2px;
                            width: 60px;
                            height: 2px;
                            background: #00580f;
                        }

                        /* Card Styling */
                        .info-card {
                            background: white;
                            border-radius: 12px;
                            padding: 1.5rem;
                            margin-bottom: 1.5rem;
                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                            border: 1px solid #e2e8f0;
                            transition: transform 0.2s, box-shadow 0.2s;
                        }

                        .info-card:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                        }

                        /* Person Card */
                        .person-card {
                            border-left: 4px solid #00580f;
                        }

                        .bride-card {
                            border-left-color: #ed64a6;
                        }

                        .photo-container {
                            width: 120px;
                            height: 120px;
                            border-radius: 12px;
                            overflow: hidden;
                            border: 3px solid white;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                            margin-bottom: 1rem;
                        }

                        .photo-container img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                        }

                        /* Status Badges */
                        .status-badge {
                            display: inline-block;
                            padding: 0.35rem 1rem;
                            border-radius: 50px;
                            font-size: 0.85rem;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }

                        .status-pending {
                            background: #fed7d7;
                            color: #c53030;
                        }

                        .status-approved {
                            background: #c6f6d5;
                            color: #276749;
                        }

                        .status-rejected {
                            background: #fed7d7;
                            color: #c53030;
                        }

                        .status-completed {
                            background: #bee3f8;
                            color: #2c5282;
                        }

                        .status-submitted {
                            background: #feebc8;
                            color: #9c4221;
                        }

                        .status-accomplished {
                            background: #c6f6d5;
                            color: #276749;
                        }

                        .status-active {
                            background: #bee3f8;
                            color: #2c5282;
                        }

                        .status-pending {
                            background: #feebc8;
                            color: #9c4221;
                        }

                        /* Info Grid */
                        .info-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                            gap: 1rem;
                            margin-top: 1rem;
                        }

                        .info-item {
                            padding: 0.75rem;
                            background: #f7fafc;
                            border-radius: 8px;
                            border-left: 3px solid #cbd5e0;
                        }

                        .info-item label {
                            display: block;
                            font-size: 0.8rem;
                            color: #718096;
                            margin-bottom: 0.25rem;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }

                        .info-item .value {
                            font-weight: 600;
                            color: #2d3748;
                            font-size: 0.95rem;
                        }

                        /* Contact Styling */
                        .contact-item {
                            display: inline-flex;
                            align-items: center;
                            padding: 0.25rem 0;
                        }

                        /* Parent Card */
                        .parent-card {
                            border-left: 3px solid #48bb78;
                            padding: 1rem;
                            margin-bottom: 1rem;
                            background: #f0fff4;
                        }

                        /* Witness Card */
                        .witness-card {
                            border-left: 3px solid #ed8936;
                            padding: 1rem;
                            margin-bottom: 1rem;
                            background: #fffaf0;
                        }

                        /* Imam Styling */
                        .imam-assigned {
                            color: #2b6cb0;
                            font-weight: 600;
                            padding: 0.75rem;
                            background: #ebf8ff;
                            border-radius: 8px;
                            display: inline-block;
                        }

                        .imam-not-assigned {
                            color: #718096;
                            font-style: italic;
                            padding: 0.75rem;
                            background: #f7fafc;
                            border-radius: 8px;
                            display: inline-block;
                        }

                        /* Responsive Adjustments */
                        @media (max-width: 768px) {
                            .modal-dialog {
                                margin: 1rem;
                            }

                            .modal-body {
                                padding: 1.5rem;
                            }

                            .info-grid {
                                grid-template-columns: 1fr;
                            }

                            .photo-container {
                                margin: 0 auto 1rem;
                            }
                        }

                        .modal-dialog-scrollable .modal-content {
                            max-height: 85vh;
                            overflow: hidden;
                        }

                        .modal-dialog-scrollable .modal-body {
                            overflow-y: auto;
                            max-height: calc(85vh - 120px);
                        }
</style>
