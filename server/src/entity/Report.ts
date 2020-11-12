import {Entity, PrimaryGeneratedColumn, Column} from "typeorm";

export enum ReportStatus {
  IN_REVIEW = 'in_review',
  TROLL = 'troll',
  SPAM = 'spam',
  OK = 'ok',
}

@Entity({
  name: 'ibkv_reports'
})
export class Report {

  @PrimaryGeneratedColumn()
  id: number

  @Column()
  name: string

  @Column()
  text: string

  @Column()
  happened_at: Date

  @Column()
  happened_where: string

  @Column()
  trigger_warning: boolean

  @Column()
  teaser: string

  @Column()
  created_at: Date

  @Column()
  published: boolean

  @Column()
  reported: boolean

  @Column()
  found_solution: boolean

  @Column()
  email: string

  @Column()
  ip_address: string

  @Column({
    type: 'enum',
    enum: ReportStatus,
    default: ReportStatus.IN_REVIEW,
  })
  status: ReportStatus
}
